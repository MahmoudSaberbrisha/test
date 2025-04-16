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
        Schema::create('car_contracts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('car_supplier_id')->unsigned()->nullable();
            $table->string('car_type')->nullable();
            $table->integer('passengers_num')->nullable();
            $table->date('license_expiration_date')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->string('image')->nullable();
            $table->string('notes')->nullable();
            $table->decimal('total', 8, 2)->nullable()->default(0.00);
            $table->decimal('paid', 8, 2)->nullable()->default(0.00);
            $table->timestamps();

            $table->foreign('car_supplier_id')->references('id')->on('car_suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
