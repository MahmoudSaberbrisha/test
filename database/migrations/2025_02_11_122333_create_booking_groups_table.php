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
        Schema::create('booking_groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id')->unsigned()->nullable();
            $table->string('booking_group_num', 255)->unique()->nullable()->index();
            $table->bigInteger('client_supplier_id')->unsigned()->nullable();
            $table->decimal('client_supplier_value', 8, 2)->nullable()->default(0.00);
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->bigInteger('currency_id')->unsigned()->nullable();
            $table->decimal('hour_member_price', 8, 2)->nullable()->default(0.00);
            $table->decimal('price', 8, 2)->nullable()->default(0.00);
            $table->decimal('discounted', 8, 2)->nullable()->default(0.00);
            $table->decimal('total_after_discount', 8, 2)->nullable()->default(0.00);
            $table->decimal('tax', 8, 2)->nullable()->default(0.00);
            $table->decimal('total', 8, 2)->nullable()->default(0.00);
            $table->string('description', 255)->nullable();
            $table->string('notes', 255)->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('is_taxed')->default(0);
            $table->boolean('out_marina')->default(0);
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('client_supplier_id')->references('id')->on('client_suppliers')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_groups');
    }
};
