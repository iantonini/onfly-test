<?php

declare(strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class Cards extends Model
{
    protected ?string $table = 'cards';
    protected array $fillable = ['id', 'fk_user', 'card_number', 'balance'];
}
