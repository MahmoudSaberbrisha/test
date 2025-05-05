<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvailableAmountToStoreItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_item', function (Blueprint $table) {
            $table->integer('available_amount')->default(0)->after('category')->comment('Available quantity of the item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_item', function (Blueprint $table) {
            $table->dropColumn('available_amount');
        });
    }
}
