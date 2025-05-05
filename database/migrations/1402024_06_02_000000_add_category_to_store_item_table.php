<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToStoreItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_item', function (Blueprint $table) {
            $table->integer('category')->default(1)->after('sanf_type_gym')->comment('1: وحدات, 2: كراتين, 3: علب');
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
            $table->dropColumn('category');
        });
    }
}
