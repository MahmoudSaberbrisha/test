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
            $table->dropForeign(['client_supplier_id']);
            $table->dropColumn('client_supplier_id');
            $table->string('supplier_type')->nullable()->default('App\Models\ClientSupplier')->after('booking_group_num');
            $table->unsignedBigInteger('client_supplier_id')->nullable()->after('supplier_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_groups', function (Blueprint $table) {
            $table->dropColumn('supplier_type');
            $table->foreign('client_supplier_id')->references('id')->on('client_suppliers')->onDelete('cascade');
        });
    }
};