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
        Schema::create('permission_group_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('permission_group_id')->unsigned();
            $table->string('locale')->index();
            $table->string('group_name')->unique();
            $table->timestamps();
            $table->unique(['permission_group_id', 'locale']);
            $table->foreign('permission_group_id')->references('id')->on('permission_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_group_translations');
    }
};
