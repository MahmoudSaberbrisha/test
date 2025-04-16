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
            Schema::create('branches', function (Blueprint $table) {
                $table->id();
                if (Features::accessible('regions-branches-feature')) {
                    $table->bigInteger('region_id')->unsigned();
                    $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
                }
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
        if (Features::accessible('branches-feature') || Features::accessible('regions-branches-feature')) {
            Schema::dropIfExists('branches');
        } else {
            return;
        }
    }
};
