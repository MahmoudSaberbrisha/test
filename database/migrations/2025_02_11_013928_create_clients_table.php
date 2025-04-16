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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('mobile')->nullable()->unique();
            $table->string('national_id')->nullable()->unique();
            $table->string('passport_number')->nullable()->unique();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('area')->nullable();
            $table->string('city')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
