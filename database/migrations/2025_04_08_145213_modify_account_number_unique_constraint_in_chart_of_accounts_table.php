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
        Schema::table('chart_of_accounts', function (Blueprint $table) {
            $table->dropUnique(['account_number']);
            $table->unique(['account_number', 'parent_id'], 'account_number_parent_unique');
        });
    }

    public function down(): void
    {
        Schema::table('chart_of_accounts', function (Blueprint $table) {
            $table->dropUnique('account_number_parent_unique');
            $table->unique(['account_number']);
        });
    }
};