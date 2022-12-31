<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('slug');
            $table->string('name');
            $table->string('description')->nullable();
    
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_desc')->nullable();
    
            $table->string('selling_price');
            $table->string('original_price');
            $table->string('quantity');
            $table->string('brand');
            $table->string('image')->nullable();
            $table->string('featured')->default('0')->nullable();
            $table->string('popular')->default('0')->nullable();
            $table->string('status')->default('0');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
