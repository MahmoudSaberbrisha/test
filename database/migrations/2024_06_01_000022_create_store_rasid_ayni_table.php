<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreRasidAyniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('store_rasid_ayni');

        Schema::create('store_rasid_ayni', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->unsignedInteger('main_branch_id_fk')->nullable();
            $table->unsignedInteger('sub_branch_id_fk')->nullable();
            $table->string('date', 15)->nullable();
            $table->string('date_ar', 15)->nullable();
            $table->string('publisher_name', 15)->nullable();
            $table->unsignedBigInteger('publisher')->nullable();
            $table->string('sanf_code', 15)->nullable();
            $table->unsignedInteger('sanf_id');
            $table->string('sanf_name', 20)->nullable();
            $table->string('sanf_amount', 20)->nullable();

            // Foreign key constraints
            $table->foreign('main_branch_id_fk')->references('id')->on('store_branch_settings')->onDelete('set null');
            $table->foreign('sub_branch_id_fk')->references('id')->on('store_branch_settings')->onDelete('set null');
            $table->foreign('publisher')->references('id')->on('users')->onDelete('set null');
            $table->foreign('sanf_id')->references('id')->on('store_item')->onDelete('cascade');
            // FK for sanf_code skipped due to string type and unclear reference
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_rasid_ayni');
    }
}
