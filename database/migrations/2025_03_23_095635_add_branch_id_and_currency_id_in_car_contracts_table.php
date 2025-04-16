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
        Schema::table('car_contracts', function (Blueprint $table) {
            $table->bigInteger('branch_id')->unsigned()->nullable()->after('car_type')->default(1);
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');

            $table->bigInteger('currency_id')->unsigned()->nullable()->after('branch_id')->default(1);
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_contracts', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');

            $table->dropForeign(['currency_id']);
            $table->dropColumn('currency_id');
        });
    }
};
