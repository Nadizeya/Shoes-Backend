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
        Schema::create('product_variation_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variation_id')
                ->constrained('product_variations')
                ->onDelete('cascade');

            // Path to the stored video
            $table->string('video_path');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variation_videos');
    }
};
