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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->string('role');
            $table->string('profile')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('Country')->nullable();
//            $table->string('postal_code')->nullable();
            // $table->string('profile')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('viber')->nullable();
            $table->string('telegram')->nullable();
            $table->integer('verify')->nullable();
            $table->integer('terminate')->nullable();
            $table->integer('code')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
