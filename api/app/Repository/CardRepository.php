<?php

namespace App\Repository;

use Hyperf\Di\Annotation\Component;
use App\Model\Card;

/**
 * @Component
 */
class CardRepository
{
    protected $model;

    public function __construct(Card $card)
    {
        $this->model = $card;
    }

    public function updateBalance(int $cardId, float $balance)
    {
        $status = false;
        $card = $this->model->find($cardId);
        if (!! $card) {
            $card->balance = $balance;
            if (!! $card->save()) {
                $status = true;
            }
        }

        return $status;
    }

    public function findById(string $cardId)
    {
        $card = $this->model->find($cardId);
        if (! $card) {
            $card = [];
        }

        return $card;
    }

    public function findCardByNumber(string $card_number)
    {
        $card = $this->model->where('card_number', $card_number)->first();
        if (! $card) {
            $card = [];
        }

        return $card;
    }

    public function registryExpense(int $cardId, float $expenseValue)
    {
        $status = false;
        $card = $this->model->find($cardId);
        if (!! $card) {
            $new_balance = $card->balance - $expenseValue;
            if ($new_balance >= 0) {
                $card->balance = $new_balance;
                if (!! $card->save()) {
                    $status = true;
                }
            }
        }

        return $status;
    }
}
