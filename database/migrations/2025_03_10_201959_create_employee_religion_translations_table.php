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
        Schema::create('employee_religion_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_religion_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->unique();
            $table->timestamps();

            $table->unique(['employee_religion_id', 'locale'], 'emp_rel_trans_unique');
            $table->foreign('employee_religion_id', 'emp_rel_trans_fk')->references('id')->on('employee_religions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_religion_translations');
    }
};
