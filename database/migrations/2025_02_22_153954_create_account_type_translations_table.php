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
        Schema::create('account_type_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_type_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->unique();
            $table->timestamps();
            $table->unique(['account_type_id', 'locale']);
            $table->foreign('account_type_id')->references('id')->on('account_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_type_translations');
    }
};
