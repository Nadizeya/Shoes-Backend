<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**x    
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_user_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_user_address');
    }
};
