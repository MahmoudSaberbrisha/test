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
        Schema::create('revenues_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('description'); // Description of the revenue or expense
            $table->decimal('amount', 10, 2); // Amount of the revenue or expense
            $table->enum('type', ['revenue', 'expense']); // Type of entry
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenues_expenses');
    }
};