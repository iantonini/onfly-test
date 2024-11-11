<?php

declare(strict_types=1);

namespace App\Seeders;

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('cards')->insert([
            ['fk_user' => 1, 'card_number' => '1111111111111111', 'balance' => 1000, 'balance_created' => 1000],
            ['fk_user' => 2, 'card_number' => '2222222222222222', 'balance' => 1000, 'balance_created' => 1000],
        ]);
    }
}
