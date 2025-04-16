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
        Schema::create('employee_identity_type_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_identity_type_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->unique();
            $table->timestamps();

            $table->unique(['employee_identity_type_id', 'locale'], 'emp_ide_trans_unique');
            $table->foreign('employee_identity_type_id', 'emp_ide_trans_fk')->references('id')->on('employee_identity_types')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_identity_type_translations');
    }
};
