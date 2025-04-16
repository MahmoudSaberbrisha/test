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
        Schema::create('sailing_boat_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sailing_boat_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->unique();
            $table->timestamps();
            $table->unique(['sailing_boat_id', 'locale']);
            $table->foreign('sailing_boat_id')->references('id')->on('sailing_boats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sailing_boat_translations');
    }
};
