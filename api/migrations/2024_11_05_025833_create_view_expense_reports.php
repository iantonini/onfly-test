<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Db::statement(
            'CREATE VIEW expense_reports AS
                SELECT
                    US.id,
                    US.superuser,
                    US.user_name,
                    US.email,
                    CA.card_number,
                    CA.balance,
                    EX.expense_value,
                    EX.previous_balance,
                    EX.current_balance
                FROM
                    users AS US,
                    cards AS CA,
                    expenses AS EX
                WHERE CA.fk_user = US.id
                    AND EX.fk_user = US.id
                    AND EX.fk_card = CA.id
                    AND EX.delete IS FALSE'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Db::statement('DROP VIEW IF EXISTS expense_reports');
    }
};
