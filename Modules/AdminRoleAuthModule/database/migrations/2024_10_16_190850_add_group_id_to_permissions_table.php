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
        Schema::table('permissions', function (Blueprint $table) {
            $table->integer('permission_order')->after('guard_name')->nullable();
            $table->bigInteger('permission_group_id')->after('permission_order')->unsigned()->nullable();
            $table->string('permission_icon')->after('permission_group_id')->nullable();
            $table->string('permission_url')->after('permission_icon')->nullable();
            $table->foreign('permission_group_id')->references('id')->on('permission_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['permission_group_id']);
            $table->dropColumn(['permission_group_id', 'permission_order', 'permission_icon', 'permission_url']);
        });
    }
};
