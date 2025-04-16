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
        Schema::create('feed_backs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->bigInteger('booking_group_id')->unsigned()->nullable();
            $table->bigInteger('experience_type_id')->unsigned()->nullable();
            $table->string('comment', 255)->nullable(); 
            $table->tinyInteger('rating')->unsigned()->checkBetween(1, 5)->default(1); 
            $table->tinyInteger('service_quality')->unsigned()->checkBetween(1, 5)->default(1);
            $table->tinyInteger('staff_behavior')->unsigned()->checkBetween(1, 5)->default(1); 
            $table->tinyInteger('cleanliness')->unsigned()->checkBetween(1, 5)->default(1); 
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('booking_group_id')->references('id')->on('booking_groups')->onDelete('cascade');
            $table->foreign('experience_type_id')->references('id')->on('experience_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_backs');
    }
};
