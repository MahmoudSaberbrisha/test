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
        Schema::create('car_expenses_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('car_expenses_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->unique();
            $table->timestamps();
            $table->unique(['car_expenses_id', 'locale']);
            $table->foreign('car_expenses_id')->references('id')->on('car_expenses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_expenses_setting_translations');
    }
};
