<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('expenses_type_id')->unsigned()->nullable();
            $table->decimal('value', 8, 2)->nullable();
            $table->string('note')->nullable();
            $table->date('expense_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('expenses_type_id')->references('id')->on('expenses_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
