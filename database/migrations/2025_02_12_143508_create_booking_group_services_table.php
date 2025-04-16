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
        Schema::create('booking_group_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id')->unsigned()->nullable();
            $table->bigInteger('branch_id')->unsigned()->nullable();
            $table->bigInteger('booking_group_id')->unsigned()->nullable();
            $table->string('booking_group_service_num', 255)->nullable()->unique()->index();
            $table->integer('services_count')->nullable();
            $table->bigInteger('extra_service_id')->unsigned()->nullable();
            $table->bigInteger('currency_id')->unsigned()->nullable();
            $table->decimal('price', 8, 2)->nullable()->default(0.00);
            $table->decimal('discounted', 8, 2)->nullable()->default(0.00);
            $table->decimal('total', 8, 2)->nullable()->default(0.00);
            $table->boolean('is_taxed')->default(0);
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('booking_group_id')->references('id')->on('booking_groups')->onDelete('cascade');
            $table->foreign('extra_service_id')->references('id')->on('extra_services')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_group_services');
    }
};
