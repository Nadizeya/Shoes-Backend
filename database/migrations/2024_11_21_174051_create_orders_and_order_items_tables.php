<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('order_user_address_id')->constrained()->onDelete('cascade');
        $table->decimal('total_price', 10, 2)->default(0);
        $table->String('order_code')->nullable();
        $table->integer('total_product')->default(0);
        $table->string('status')->default('placed'); // e.g., pending, completed
        $table->timestamps();
    });

    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_variation_id')->constrained('product_variations')->onDelete('cascade');
        $table->integer('quantity');
        $table->decimal('price', 10, 2); // Price at the time of purchase
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(['orders','order_items']);
    }
};
