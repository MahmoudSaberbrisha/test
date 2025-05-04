<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorePurchasesOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('store_purchases_others');

        Schema::create('store_purchases_others', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->string('fatora_code', 20);
            $table->unsignedInteger('main_branch_id_fk');
            $table->unsignedInteger('sub_branch_id_fk');
            $table->string('product_code', 20);
            $table->string('product_name', 50);
            $table->string('amount_buy', 20);
            $table->string('all_cost_buy', 20);
            $table->string('one_price_sell', 20);
            $table->decimal('one_price_buy', 19, 2)->nullable();
            $table->decimal('rasid_motah', 19, 2)->nullable();
            $table->integer('date_s');
            $table->string('date_ar', 20)->default('0');
            $table->unsignedInteger('publisher');
            $table->string('had_back', 20)->default('0');
            $table->string('had_back_date', 20)->default('0');
            $table->string('had_back_amount', 20)->default('0');
            $table->boolean('old')->default(false);

            // Foreign key constraints
            $table->foreign('main_branch_id_fk')->references('id')->on('store_branch_settings')->onDelete('cascade');
            $table->foreign('sub_branch_id_fk')->references('id')->on('store_branch_settings')->onDelete('cascade');
            // FK for publisher skipped due to unclear reference
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_purchases_others');
    }
}
