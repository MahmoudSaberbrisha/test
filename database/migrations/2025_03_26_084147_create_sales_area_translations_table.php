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
        Schema::create('sales_area_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sales_area_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->timestamps();
            $table->unique(['sales_area_id', 'locale']);
            $table->foreign('sales_area_id')->references('id')->on('sales_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_area_translations');
    }
};
