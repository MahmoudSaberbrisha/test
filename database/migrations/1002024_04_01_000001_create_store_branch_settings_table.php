<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStoreBranchSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_branch_settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->string('title', 15);
            $table->enum('br_code', ['A', 'B', 'C', ''])->nullable();
            $table->unsignedInteger('from_id')->nullable();
            $table->string('lat_map', 15)->nullable();
            $table->string('long_map', 15)->nullable();

            // Foreign key constraint for self-reference
            $table->foreign('from_id')->references('id')->on('store_branch_settings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('store_branch_settings');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
