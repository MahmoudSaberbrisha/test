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
            $table->boolean('credit_sales')->after('is_taxed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_groups', function (Blueprint $table) {
            $table->dropColumn('credit_sales');
        });
    }
};
