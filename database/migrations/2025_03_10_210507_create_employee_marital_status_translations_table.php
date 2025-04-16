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
        Schema::create('employee_marital_status_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_marital_status_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->unique();
            $table->timestamps();

            $table->unique(['employee_marital_status_id', 'locale'], 'emp_mar_trans_unique');
            $table->foreign('employee_marital_status_id', 'emp_mar_trans_fk')->references('id')->on('employee_marital_status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_marital_status_translations');
    }
};
