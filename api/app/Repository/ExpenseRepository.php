<?php

namespace App\Repository;

use Hyperf\Di\Annotation\Component;
use App\Model\Expense;

/**
 * @Component
 */
class ExpenseRepository
{
    protected $model;

    public function __construct(Expense $expense)
    {
        $this->model = $expense;
    }

    public function findById(string $expenseId)
    {
        $expense = $this->model->find($expenseId);
        if (! $expense) {
            $expense = [];
        }

        return $expense;
    }

    public function isPreviousDeletionRecord(int $id, int $cardId, int $count=0)
    {
        $expense = $this->model->where('deleted', $id)->where('fk_card', $cardId)->first();
        if (isset($expense) && isset($expense->id)) {
            $expense = $this->isPreviousDeletionRecord($expense->id, $expense->fk_card, ++$count);
        } else {
            $expense = $count;
        }

        return $expense;
    }

    public function createExpense(array $data)
    {
        $expense = $this->model->create($data);
        if (! $expense) {
            $expense = [];
        }
        return $expense;
    }

    public function deleteExpense(array $data)
    {
        $expense = $this->model->find($data['id']);
        $expense->delete = $data['delete_id'];
        if (! $expense->save()) {
            $expense = [];
        }
        return $expense;
    }
}
