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
        Schema::create('car_task_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('car_task_id')->unsigned();
            $table->time('time')->index();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->timestamps();

            $table->foreign('car_task_id')->references('id')->on('car_tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_task_details');
    }
};
