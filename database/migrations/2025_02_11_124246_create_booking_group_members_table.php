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
        Schema::create('booking_group_members', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id')->unsigned()->nullable();
            $table->bigInteger('booking_group_id')->unsigned()->nullable();
            $table->bigInteger('client_type_id')->unsigned()->nullable();
            $table->integer('members_count')->nullable();
            $table->enum('discount_type', ['fixed', 'percentage'])->default('percentage');
            $table->decimal('discount_value', 8, 2)->nullable()->default(0.00);
            $table->decimal('member_price', 8, 2)->nullable()->default(0.00);
            $table->decimal('member_total_price', 8, 2)->nullable()->default(0.00);
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('booking_group_id')->references('id')->on('booking_groups')->onDelete('cascade');
            $table->foreign('client_type_id')->references('id')->on('client_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_group_members');
    }
};
