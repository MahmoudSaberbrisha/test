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
        Schema::create('car_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('serial_num', 255)->unique()->nullable()->index();
            $table->bigInteger('car_contract_id')->unsigned()->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->decimal('total_expenses', 8, 2)->nullable()->default(0.00);
            $table->decimal('car_income', 8, 2)->nullable()->default(0.00);
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->foreign('car_contract_id')->references('id')->on('car_contracts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_tasks');
    }
};
