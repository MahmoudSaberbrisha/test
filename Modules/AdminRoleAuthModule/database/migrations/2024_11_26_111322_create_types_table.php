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
        if (Features::accessible('types-feature')) {
            Schema::create('types', function (Blueprint $table) {
                $table->id();
                $table->boolean('active')->default(1);
                $table->timestamps();
                $table->softDeletes();
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
        if (Features::accessible('types-feature')) {
            Schema::dropIfExists('types');
        } else {
            return;
        }
    }
};
