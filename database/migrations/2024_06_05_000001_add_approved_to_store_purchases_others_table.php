<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedToStorePurchasesOthersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('store_purchases_others', function (Blueprint $table) {
            $table->boolean('approved')->default(false)->after('old');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('store_purchases_others', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
    }
}
