<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User;
use App\Model\Card;
use App\Model\Expense;


class ExpenseController extends AbstractController
{
    private $requiredFields = ['token', 'user_id', 'balance'];
    private $countCards = 0;

    public function listCardExpenses()
    {
        $status = 'error';
        $msg = 'token is required';
        $user = [];
        $cards = [];
        $expenses = [];

        $token = $this->request->input('token');
        $card_number = $this->request->input('card_number');

        if (isset($token)) {
            $msg = 'card_number is required';
            if (isset($card_number)) {
                $msg = 'Unable to find a user with the provided token';

                $userToken = $this->tokenService->getUserByToken($token);
                if ($userToken) {
                    $msg = 'No cards with specified token were found';

                    $cards = Card::where('card_number', $card_number)
                        ->select('id', 'card_number', 'balance_created', 'balance', 'deleted')
                        ->first();

                    if (!! $cards) {
                        $msg = 'No expenses for the specified card were found';

                        $expenses = Expense::where('fk_card', $cards->id)
                            ->where('deleted', false)
                            ->select(
                                'id', 'previous_balance', 'expense_value',
                                'current_balance', 'deleted', 'registered_by_user'
                            )->get();

                        if (!! $expenses) {
                            $status = 'success';
                            $msg = 'success';        
                        }
                    }
                }
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'card' => $cards,
            'expenses' => $expenses,
        ]);
    }

    public function createExpense()
    {
        $user = [];
        $cards = [];
        $expenses = [];
        $expenseCreated = [];

        $status = 'error';
        $msg = 'token is required';

        $data = $this->request->all();

        $token = $data['token'];
        $card_number = $data['card_number'];

        if (isset($token)) {
            $msg = 'card_number is required';
            if (isset($card_number)) {
                $msg = 'Unable to find a user with the provided token';

                $userToken = $this->tokenService->getUserByToken($token);
                if (!! $userToken) {
                    $msg = 'The card provided was not found';

                    if (!! $userToken->superuser) {
                        $cards = Card::where('deleted', false)
                        ->where('card_number', $card_number)
                        ->select('id', 'card_number', 'balance_created', 'balance', 'deleted')
                        ->first();
                    } else {
                        $cards = Card::where('fk_user', $userToken->id)
                        ->where('deleted', false)
                        ->where('card_number', $card_number)
                        ->select('id', 'card_number', 'balance_created', 'balance', 'deleted')
                        ->first();
                    }
    
                    if (!! $cards) {
                        $msg = 'The expense (expense_value) must have a value greater than zero';
    
                        if ($data['expense_value'] > 0) {
                            $msg = 'Failed to record expenses. Check balance';

                            $transactionExpense = $this->transactionService->createExpense(
                                $card_number, $data['expense_value'], $userToken->id
                            );
    
                            if (!! $transactionExpense) {
                                $expenseCreated = [
                                    'id' => $transactionExpense->id,
                                    'card_number' => $cards->card_number,
                                    'expense_value' => (float) $transactionExpense->expense_value,
                                    'previous_balance' => (float) $transactionExpense->previous_balance,
                                    'current_balance' => (float) $transactionExpense->current_balance,
                                ];
    
                                // $this->sendMailService->send($mail);
    
                                $status = 'success';
                                $msg = 'success';
                            }
                        }
                    }
                }
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'expenses' => $expenseCreated,
        ]);
    }

    public function deleteExpense()
    {
        $user = [];
        $cards = [];
        $expenses = [];
        $expenseCreated = [];

        $status = 'error';
        $msg = 'token is required';

        $data = $this->request->all();

        $token = $data['token'];
        $expense_id = $data['expense_id'];

        if (isset($token)) {
            $msg = 'expense_id is required';
            if (isset($expense_id)) {
                $msg = 'Unable to find a user with the provided token';

                $userToken = $this->tokenService->getUserByToken($token);
                if (!! $userToken) {
                    $msg = 'The card provided was not found';

                    if (!! $userToken->superuser) {
                        $expense = Expense::where('deleted', false)
                        ->where('id', $expense_id)
                        ->first();
                    } else {
                        $expense = Expense::where('registered_by_user', $userToken->id)
                        ->where('deleted', false)
                        ->where('id', $expense_id)
                        ->first();
                    }
    
                    if (!! $expense) {
                        $msg = 'Failed to record expenses. Check balance';

                        $transactionExpense = $this->transactionService->deleteExpense(
                            $data['expense_id'], $userToken->id
                        );

                        if (!! $transactionExpense) {
                            $expenseCreated = [
                                'id' => $transactionExpense->id,
                                'expense_value' => (float) $transactionExpense->expense_value,
                                'previous_balance' => (float) $transactionExpense->previous_balance,
                                'current_balance' => (float) $transactionExpense->current_balance,
                            ];

                            // $this->sendMailService->send($mail);

                            $status = 'success';
                            $msg = 'success';
                        }
                    }
                }
            }
        }

        return $this->response->json([
            'status' => $status,
            'message' => $msg,
            'expenses' => $expenseCreated,
        ]);
    }
}
