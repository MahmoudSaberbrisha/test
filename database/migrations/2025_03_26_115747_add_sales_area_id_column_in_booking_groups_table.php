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
        Schema::table('booking_groups', function (Blueprint $table) {
            $table->bigInteger('sales_area_id')->unsigned()->nullable()->after('booking_group_num');
            $table->foreign('sales_area_id')->references('id')->on('sales_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_groups', function (Blueprint $table) {
            $table->dropForeign(['sales_area_id']);
            $table->dropColumn('sales_area_id');
        });
    }
};
