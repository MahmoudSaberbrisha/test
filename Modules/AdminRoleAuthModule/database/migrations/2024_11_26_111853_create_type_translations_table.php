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
            Schema::create('type_translations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('type_id')->unsigned();
                $table->string('locale')->index();
                $table->string('name')->unique();
                $table->timestamps();
                $table->unique(['type_id', 'locale']);
                $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
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
            Schema::dropIfExists('type_translations');
        } else {
            return;
        }
    }
};
