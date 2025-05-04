<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('store_item');

        Schema::create('store_item', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->string('name', 50);
            $table->string('sanf_code', 50);
            $table->index('sanf_code');
            $table->string('sanf_type', 50)->default('0');
            $table->unsignedInteger('main_branch_id_fk');
            $table->unsignedInteger('sub_branch_id_fk');
            $table->string('unit', 50);
            $table->string('limit_order', 50);
            $table->string('min_limit', 50);
            $table->decimal('all_buy_cost', 19, 2);
            $table->string('all_amount', 50);
            $table->decimal('one_buy_cost', 19, 2);
            $table->decimal('customer_price_sale', 19, 2)->default(0.00);
            $table->string('first_balance_period', 50);
            $table->float('past_amount');
            $table->string('cost_past_amount', 50);
            $table->integer('sanf_type_gym')->default(0);

            // Foreign key constraints
            $table->foreign('main_branch_id_fk')->references('id')->on('store_branch_settings')->onDelete('cascade');
            $table->foreign('sub_branch_id_fk')->references('id')->on('store_branch_settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_item');
    }
}
