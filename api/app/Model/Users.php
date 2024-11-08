<?php

declare(strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class Users extends Model
{
    protected ?string $table = 'users';
    protected array $fillable = ['id', 'superuser', 'user_name', 'email'];
}
