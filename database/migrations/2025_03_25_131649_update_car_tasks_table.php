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
        Schema::table('car_tasks', function (Blueprint $table) {
            $table->bigInteger('currency_id')->unsigned()->nullable()->after('car_contract_id')->default(1);
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->decimal('paid', 8, 2)->nullable()->after('currency_id')->default(0.00);
            
            $table->date('date')->nullable()->after('paid');
            $table->dropColumn(['start_date', 'end_date', 'from', 'to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_tasks', function (Blueprint $table) {
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            
            $table->dropColumn('date');
            $table->dropForeign(['currency_id']);
            $table->dropColumn('currency_id');
            $table->dropColumn('paid');
        });
    }
};