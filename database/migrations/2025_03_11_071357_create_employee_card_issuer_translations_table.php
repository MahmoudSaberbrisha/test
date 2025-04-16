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
        Schema::create('employee_card_issuer_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_card_issuer_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->unique();
            $table->timestamps();

            $table->unique(['employee_card_issuer_id', 'locale'], 'emp_car_trans_unique');
            $table->foreign('employee_card_issuer_id', 'emp_car_trans_fk')->references('id')->on('employee_card_issuers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_card_issuer_translations');
    }
};
