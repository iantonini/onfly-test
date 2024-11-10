<?php

namespace App\Service;

use Hyperf\DbConnection\Db;
use App\Models\Card;
use App\Models\Expense;

class ExpenseService
{
    private $expenseCreated;

    public function __construct()
    {
        $this->expenseCreated = false;
    }

    public function showExpensesCard($cardId)
    {
        try {
            $expenses = Expense::where('id', $cardId)->where('deleted', false)->get();
        } catch (\Exception $e) {
            return "Erro: " . $e->getMessage();
        }
        return $expenses;
    }

    public function showExpensesUser($userId)
    {
        try {
            $expenses = Expense::where('id', $userId)->where('deleted', false)->get();
        } catch (\Exception $e) {
            return "Erro: " . $e->getMessage();
        }
        return $expenseCreated;
    }

    public function createExpense(array $cardData, array $expenseData)
    {
        try {
            Db::transaction(function () use ($cardData, $expenseData) {
                $card = Card::where('id', $cardData['id'])->firstOrFail();
                $card->update([
                    'balance' => $cardData['balance']
                ]);

                Expense::create([
                    'registered_by_user' => $expenseData['registered_by_user'],
                    'fk_card' => $expenseData['fk_card'],
                    'expense_value' => $expenseData['expense_value'],
                    'privious_balance' => $expenseData['privious_balance'],
                    'current_balance' => $expenseData['current_balance'],
                ]);
            });

            $this->expenseCreated = true;
        } catch (\Exception $e) {
            return "Erro na transação: " . $e->getMessage();
        }

        return $expenseCreated;
    }

    public function deleteExpense($card)
    {
        return ["deletar despesas do cartao {$card} informado"];
    }
























}
