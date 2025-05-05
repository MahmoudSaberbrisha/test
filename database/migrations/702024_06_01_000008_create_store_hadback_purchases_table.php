<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreHadbackPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('store_hadback_purchases');

        Schema::create('store_hadback_purchases', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->unsignedInteger('main_branch_id_fk');
            $table->unsignedInteger('sub_branch_id_fk');
            $table->unsignedInteger('supplier_code')->nullable();
            $table->unsignedInteger('fatora_code');
            $table->unsignedInteger('product_code');
            $table->string('amount_buy', 50);
            $table->string('all_cost_buy', 50);
            $table->string('one_price_sell', 50);
            $table->integer('hadback_amount');
            $table->integer('date');
            $table->integer('date_s');
            $table->unsignedBigInteger('publisher')->nullable();

            // Foreign key constraints
            $table->foreign('main_branch_id_fk')->references('id')->on('store_branch_settings')->onDelete('cascade');
            $table->foreign('sub_branch_id_fk')->references('id')->on('store_branch_settings')->onDelete('cascade');
            $table->foreign('supplier_code')->references('code')->on('store_other_suppliers')->onDelete('set null');
            $table->foreign('publisher')->references('id')->on('users')->onDelete('set null');
            // FK for fatora_code and product_code skipped due to unclear references
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_hadback_purchases');
    }
}
