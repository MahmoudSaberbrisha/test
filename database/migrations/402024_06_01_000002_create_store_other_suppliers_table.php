<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreOtherSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('store_other_suppliers');

        Schema::create('store_other_suppliers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->unsignedInteger('code')->unique();
            $table->string('name', 15);
            $table->string('supplier_address', 15);
            $table->string('supplier_phone', 15);
            $table->string('supplier_fax', 15);
            $table->string('accountant_name', 15);
            $table->string('accountant_telephone', 15);
            $table->decimal('supplier_dayen', 19, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_other_suppliers');
    }
}