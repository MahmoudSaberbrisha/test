<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('code')->unique();
            $table->bigInteger('account_type_id')->unsigned();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_payment')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('account_type_id')->references('id')->on('account_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
