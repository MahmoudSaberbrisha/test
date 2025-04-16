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
        Schema::create('good_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('good_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->unique();
            $table->timestamps();
            $table->unique(['good_id', 'locale']);
            $table->foreign('good_id')->references('id')->on('goods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('good_translations');
    }
};
