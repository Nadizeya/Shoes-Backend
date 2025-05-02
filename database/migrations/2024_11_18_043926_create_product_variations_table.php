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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade');

            $table->string('size');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);

            // New columns for variation stock and sell counts
            $table->integer('stock_qty')->default(0);
            $table->integer('sell_qty')->default(0);

            $table->timestamps();

            // Unique constraint to avoid duplicating size/color for the same product
            $table->unique(['product_id', 'size'], 'unique_product_variation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
