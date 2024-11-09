<?php

declare(strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class Expense extends Model
{
    protected ?string $table = 'expenses';
    protected array $fillable = [
        'id',
        'fk_user',
        'fk_card',
        'expense_value',
        'previous_balance',
        'current_balance',
        'delete',
    ];
}
