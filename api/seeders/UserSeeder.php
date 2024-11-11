<?php

declare(strict_types=1);

namespace App\Seeders;

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('users')->insert([
            ['superuser' => true, 'email' => 'root@onfly.com', 'user_name' => 'Root Onfly'],
            ['superuser' => false, 'email' => 'user@onfly.com', 'user_name' => 'User Onfly'],
        ]);
    }
}
