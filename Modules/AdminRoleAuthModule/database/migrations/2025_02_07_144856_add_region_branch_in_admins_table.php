<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use YlsIdeas\FeatureFlags\Facades\Features;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Features::accessible('branches-feature') || Features::accessible('regions-branches-feature')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('image');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
                if (Features::accessible('regions-branches-feature')) {
                    $table->unsignedBigInteger('region_id')->nullable()->after('image');
                    $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null');
                }
            });
        } else {
            return;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Features::accessible('branches-feature') || Features::accessible('regions-branches-feature')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropForeign(['branch_id']);
                $table->dropColumn('branch_id');
                if (Features::accessible('regions-branches-feature')) {
                    $table->dropForeign(['region_id']);
                    $table->dropColumn('region_id');
                }
            });
        } else {
            return;
        }
    }
};
