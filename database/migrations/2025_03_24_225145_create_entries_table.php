<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('entry_number');
            $table->string('account_name');
            $table->string('account_name2');
            $table->string('account_number');
            $table->string('account_number2');
            $table->string('cost_center');
            $table->string('cost_center2');
            $table->string('reference');
            $table->string('reference2');
            $table->decimal('debit', 10, 2);
            $table->decimal('credit', 10, 2);
            $table->decimal('totel', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
