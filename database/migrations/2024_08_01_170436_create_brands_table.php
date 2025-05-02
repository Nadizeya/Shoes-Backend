<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->foreignId('main_category_id')->constrained('main_categories')->onDelete('cascade');
//            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            // To store the image path
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
