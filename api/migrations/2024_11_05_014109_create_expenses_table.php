<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('fk_card')->constrained('cards')->onDelete('cascade');
            $table->decimal('expense_value', 10, 2)->default(0)->unsigned();
            $table->decimal('previous_balance', 10, 2)->default(0)->unsigned();
            $table->decimal('current_balance', 10, 2)->default(0)->unsigned();
            $table->bigInteger('deleted')->unsigned()->default(0);
            $table->foreignId('registered_by_user')->constrained('users')->onDelete('cascade');
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
