<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->unique();
            $table->string('image')->nullable();
            $table->enum('bank_type', ['bank_account', 'pay_number']);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('banks');
    }
}

