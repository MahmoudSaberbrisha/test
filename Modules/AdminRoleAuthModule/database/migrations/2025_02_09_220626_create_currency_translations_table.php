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
            Schema::create('currency_translations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('currency_id')->unsigned();
                $table->string('locale')->index();
                $table->string('name')->unique();
                $table->timestamps();
                $table->unique(['currency_id', 'locale']);
                $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
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
            Schema::dropIfExists('currency_translations');
        } else {
            return;
        }
    }
};
