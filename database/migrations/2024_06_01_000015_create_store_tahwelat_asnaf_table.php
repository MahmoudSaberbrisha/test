<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreTahwelatAsnafTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('store_tahwelat_asnaf');

        Schema::create('store_tahwelat_asnaf', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->unsignedInteger('rkm_fk')->nullable();
            $table->unsignedInteger('sanf_id')->nullable();
            $table->string('sanf_n', 50)->nullable();
            $table->unsignedInteger('sanf_code')->nullable();
            $table->integer('amount_motah')->nullable();
            $table->integer('amount_send')->nullable();
            $table->unsignedInteger('from_storage')->nullable();
            $table->unsignedInteger('to_storage')->nullable();

            // Foreign key constraints
            $table->foreign('rkm_fk')->references('id')->on('store_tahwelat')->onDelete('cascade');
            $table->foreign('sanf_id')->references('id')->on('store_item')->onDelete('set null');
            $table->foreign('from_storage')->references('id')->on('store_other_storage')->onDelete('set null');
            $table->foreign('to_storage')->references('id')->on('store_other_storage')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_tahwelat_asnaf');
    }
}
