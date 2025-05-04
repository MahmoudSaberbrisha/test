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
        Schema::table('admins', function (Blueprint $table) {
            $table->bigInteger('setting_job_id')->unsigned()->nullable()->default(1)->after('user_name');
            $table->foreign('setting_job_id')->references('id')->on('setting_jobs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['setting_job_id']);
            $table->dropColumn(['setting_job_id']);
        });
    }
};
