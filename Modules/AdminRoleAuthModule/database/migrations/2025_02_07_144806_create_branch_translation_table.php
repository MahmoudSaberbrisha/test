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
            Schema::create('branch_translations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('branch_id')->unsigned();
                $table->string('locale')->index();
                $table->string('name')->unique();
                $table->timestamps();
                $table->unique(['branch_id', 'locale']);
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
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
            Schema::dropIfExists('branch_translations');
        } else {
            return;
        }
    }
};
