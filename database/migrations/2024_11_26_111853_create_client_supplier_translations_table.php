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
        Schema::create('client_supplier_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_supplier_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name')->unique();
            $table->timestamps();
            $table->unique(['client_supplier_id', 'locale']);
            $table->foreign('client_supplier_id')->references('id')->on('client_suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_supplier_translations');
    }
};
