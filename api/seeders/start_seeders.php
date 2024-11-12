<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class StartSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Users
        Db::table('users')->insert([
            ['id' => 1, 'superuser' => true, 'email' => 'root@onfly.com', 'user_name' => 'Root Onfly', 'created_at' => '2024-01-01 00:00:00', 'updated_at' => '2024-01-01 00:00:00'],
            ['id' => 2, 'superuser' => false, 'email' => 'user@onfly.com', 'user_name' => 'User Onfly', 'created_at' => '2024-01-01 00:00:00', 'updated_at' => '2024-01-01 00:00:00'],
        ]);

        // Cards
        Db::table('cards')->insert([
            ['id' => 1, 'fk_user' => 1, 'card_number' => '1111111111111111', 'balance' => 1000, 'balance_created' => 1000, 'created_at' => '2024-01-01 00:00:00', 'updated_at' => '2024-01-01 00:00:00'],
            ['id' => 2, 'fk_user' => 2, 'card_number' => '2222222222222222', 'balance' => 1000, 'balance_created' => 1000, 'created_at' => '2024-01-01 00:00:00', 'updated_at' => '2024-01-01 00:00:00'],
        ]);
    }
}
