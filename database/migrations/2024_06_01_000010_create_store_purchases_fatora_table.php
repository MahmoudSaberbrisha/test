<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorePurchasesFatoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('store_purchases_fatora');

        Schema::create('store_purchases_fatora', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->unsignedInteger('main_branch_id_fk');
            $table->unsignedInteger('sub_branch_id_fk');
            $table->string('fatora_date', 15);
            $table->string('supplier_code', 15);
            $table->string('fatora_cost_before_discount', 255);
            $table->string('discount', 300);
            $table->string('fatora_cost_after_discount', 300);
            $table->integer('paid_type');
            $table->integer('box_name');
            $table->integer('paid', 300);
            $table->string('remain', 300);
            $table->string('byan', 255);
            $table->date('date');
            $table->date('date_s');
            $table->string('publisher', 300);
            $table->string('had_back')->default(0);
            $table->string('sarf_far3_pill_num', 255)->nullable();

            // Foreign key constraints
            $table->foreign('main_branch_id_fk')->references('id')->on('store_branch_settings')->onDelete('cascade');
            $table->foreign('sub_branch_id_fk')->references('id')->on('store_branch_settings')->onDelete('cascade');
            // Skipping FK for supplier_code due to type mismatch
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_purchases_fatora');
    }
}
