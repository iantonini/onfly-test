<?php

declare(strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class Expenses extends Model
{
    protected ?string $table = 'expenses';
    protected array $fillable = [
        'id',
        'id_user',
        'id_card',
        'expense_value',
        'previous_balance',
        'current_balance',
        'delete'
    ];
}
