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
        if (Features::accessible('regions-branches-feature')) {
            Schema::create('region_translations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('region_id')->unsigned();
                $table->string('locale')->index();
                $table->string('name')->unique();
                $table->timestamps();
                $table->unique(['region_id', 'locale']);
                $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
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
        if (Features::accessible('regions-branches-feature')) {
            Schema::dropIfExists('region_translations');
        } else {
            return;
        }
    }
};
