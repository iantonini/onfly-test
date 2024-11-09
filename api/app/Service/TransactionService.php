<?php

namespace App\Service;

use Hyperf\DbConnection\Db;

use App\Repository\CardRepository;
use App\Repository\ExpenseRepository;


class TransactionService
{
    /**
     * @Inject
     * @var CardRepository
     */
    protected $CardRepository;

    /**
     * @Inject
     * @var ExpenseRepository
     */
    protected $ExpenseRepository;

    private $expenseCreated;

    public function __construct(CardRepository $CardRepository, ExpenseRepository $ExpenseRepository)
    {
        $this->CardRepository = $CardRepository;
        $this->ExpenseRepository = $ExpenseRepository;

        $this->expenseCreated = false;
    }

    public function createExpense(string $card_number, float $expense, int $registered_by_user)
    {
        try {
            Db::transaction(function () use ($card_number, $expense, $registered_by_user) {
                $card = $this->CardRepository->findCardByNumber($card_number);
                if (!! $card) {
                    if ($card->balance >= 0 && $expense > 0) {
                        $new_balance = $card->balance - $expense;

                        if ($new_balance >= 0) {
                            $updateCard = $this->CardRepository->updateBalance($card->id, $new_balance);

                            $dataExpense = [
                                'fk_user' => $registered_by_user,
                                'fk_card' => $card->id,
                                'expense_value' => $expense,
                                'previous_balance' => $card->balance,
                                'current_balance' => $new_balance,
                            ];
                            $updateExpense = $this->ExpenseRepository->createExpense($dataExpense);

                            if ((!! $updateCard) && (!! $updateExpense)) {
                                $this->expenseCreated = $updateExpense;
                            }
                        }
                    }
                }
            });
        } catch (\Exception $e) {
            return 'Transaction fail';
        }

        return $this->expenseCreated;
    }

    public function deleteExpense(int $expense_id, int $registered_by_user)
    {
        try {
            Db::transaction(function () use ($expense_id, $registered_by_user) {
                $expense_delete = $this->ExpenseRepository->findById($expense_id);
                if (!! $expense_delete) {
                    $card = $this->CardRepository->findById($expense_delete->fk_card);
                    if (!! $card) {
                        $new_balance = $expense_delete->expense_value + $expense_delete->current_balance;

                        $isPreviousDeletionRecord = $this->ExpenseRepository->isPreviousDeletionRecord(
                            $expense_delete->id,
                            $expense_delete->fk_card
                        );

                        if ($isPreviousDeletionRecord % 2 != 0) {
                            $new_balance = $expense_delete->previous_balance
                                - $expense_delete->expense_value
                                + $card->balance
                                - $expense_delete->previous_balance;
                        }

                        $updateCard = $this->CardRepository->updateBalance($card->id, $new_balance);

                        $dataCreateExpense = [
                            'fk_user' => $registered_by_user,
                            'fk_card' => $expense_delete->fk_card,
                            'expense_value' => $expense_delete->expense_value,
                            'previous_balance' => $expense_delete->current_balance,
                            'current_balance' => $new_balance,
                        ];
                        $createExpense = $this->ExpenseRepository->createExpense($dataCreateExpense);

                        if (!! $createExpense) {
                            $dataDeleteExpense = [
                                'id' => $expense_delete->id,
                                'delete_id' => $createExpense->id,
                            ];
                            $deleteExpense = $this->ExpenseRepository->deleteExpense($dataDeleteExpense);
                        }

                        if ((!! $updateCard) && (!! $createExpense)) {
                            $this->expenseCreated = $createExpense;
                        }
                    }
                }

            });
        } catch (\Exception $e) {
            return 'Transaction fail';
        }

        return $this->expenseCreated;
    }
}
