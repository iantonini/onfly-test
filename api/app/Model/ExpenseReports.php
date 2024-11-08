<?php

declare(strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class ExpenseReports extends Model
{
    protected ?string $table = 'expense_reports';
    protected array $fillable = [
        'id',
        'superuser',
        'user_name',
        'email',
        'card_number',
        'balance',
        'expense_value',
        'previous_balance',
        'current_balance'
    ];
}
