<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('store_inventory_table');

        Schema::create('store_inventory_table', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->unsignedInteger('item_id_fk');
            $table->string('storage_id_fk', 50)->default('0');
            $table->integer('amount');
            $table->integer('num_invent');
            $table->string('available_amount', 50)->default('0');
            $table->string('invent_date', 50);
            $table->boolean('sanf_type_gym')->default(false);
            $table->unsignedBigInteger('employee_id_fk')->nullable();
            $table->string('date', 50);
            $table->string('date_s', 50);
            $table->string('date_ar', 50);
            $table->string('publisher', 50);
            $table->string('sub_branch_id_fk', 50)->default('0');
            $table->integer('emp_code')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('deficit_amount')->default(0);
            $table->integer('increase_amount')->default(0);
            $table->string('notes', 50)->nullable();

            // Foreign key constraints
            $table->foreign('item_id_fk')->references('id')->on('store_item')->onDelete('cascade');
            // Assuming storage_id_fk references a storage table, but type is string, so skipping FK
            // Assuming employee_id_fk references employees table
            $table->foreign('employee_id_fk')->references('id')->on('admins')->onDelete('set null');
            // Assuming user_id references users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            // Assuming sub_branch_id_fk references branches table, but type is string, so skipping FK
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_inventory_table');
    }
}
