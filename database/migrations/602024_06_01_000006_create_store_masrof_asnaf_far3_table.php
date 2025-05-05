<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreMasrofAsnafFar3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('store_masrof_asnaf_far3');

        Schema::create('store_masrof_asnaf_far3', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->unsignedInteger('main_branch_fk')->default(1);
            $table->unsignedInteger('sub_branch_fk')->nullable();
            $table->unsignedInteger('sarf_rkm')->nullable();
            $table->unsignedInteger('sarf_to')->nullable();
            $table->unsignedInteger('sanf_code')->nullable();
            $table->integer('available_amount')->nullable();
            $table->integer('sanf_amount')->nullable();
            $table->integer('one_price_sell')->nullable();
            $table->integer('date');
            $table->string('date_ar', 15)->nullable();
            $table->unsignedBigInteger('publisher')->nullable();
            $table->string('publisher_name', 20)->nullable();

            // Foreign key constraints
            $table->foreign('main_branch_fk')->references('id')->on('store_branch_settings')->onDelete('cascade');
            $table->foreign('sub_branch_fk')->references('id')->on('store_branch_settings')->onDelete('cascade');
            $table->foreign('publisher')->references('id')->on('users')->onDelete('set null');
            // FK for sarf_rkm, sarf_to, sanf_code skipped due to unclear references
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_masrof_asnaf_far3');
    }
}
