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
        Schema::create('car_task_expenses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('car_task_id')->unsigned();
            $table->bigInteger('car_expenses_id')->unsigned();
            $table->decimal('total', 8, 2)->default(0.00);
            $table->timestamps();
        
            $table->foreign('car_task_id')->references('id')->on('car_tasks')->onDelete('cascade');
            $table->foreign('car_expenses_id')->references('id')->on('car_expenses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_task_expenses');
    }
};
