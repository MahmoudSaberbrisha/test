<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreRequestsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('store_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('fatora_code');
            $table->integer('main_branch_id_fk');
            $table->integer('sub_branch_id_fk');
            $table->string('product_code');
            $table->string('product_name', 255);
            $table->decimal('amount_buy', 15, 2);
            $table->decimal('all_cost_buy', 15, 2);
            $table->decimal('one_price_sell', 15, 2);
            $table->decimal('one_price_buy', 15, 2);
            $table->decimal('rasid_motah', 15, 2);
            $table->date('date_s');
            $table->date('date_ar')->nullable();
            $table->integer('publisher');
            $table->integer('had_back');
            $table->date('had_back_date')->nullable();
            $table->decimal('had_back_amount', 15, 2);
            $table->boolean('old')->default(false);
            $table->boolean('approved')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('store_requests');
    }
}
