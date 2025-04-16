<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropForeign(['chart_of_account_id']);
            $table->dropColumn('chart_of_account_id');
        });
    }

    public function down()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->unsignedBigInteger('chart_of_account_id')->nullable();
        });
    }
};
