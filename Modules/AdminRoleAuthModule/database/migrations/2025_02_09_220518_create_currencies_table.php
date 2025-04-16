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
        if (Features::accessible('currencies-feature')) {
            Schema::create('currencies', function (Blueprint $table) {
                $table->id();
                $table->string('code')->nullable();
                $table->string('symbol')->nullable();
                $table->string('color')->nullable();
                $table->boolean('active')->default(1);
                $table->boolean('default')->default(0);
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
        if (Features::accessible('currencies-feature')) {
            Schema::dropIfExists('currencies');
        } else {
            return;
        }
    }
};
