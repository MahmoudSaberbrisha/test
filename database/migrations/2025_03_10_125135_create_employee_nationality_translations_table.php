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
        Schema::create('employee_nationality_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_nationality_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->unique();
            $table->timestamps();

            $table->unique(['employee_nationality_id', 'locale'], 'emp_nat_trans_unique');
            $table->foreign('employee_nationality_id', 'emp_nat_trans_fk')->references('id')->on('employee_nationalities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_nationality_translations');
    }
};