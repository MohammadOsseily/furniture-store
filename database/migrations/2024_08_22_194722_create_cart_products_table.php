<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class  extends Migration
{
    public function up()
    {
        Schema::create('cart_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_is')->constrained('shopping_carts')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('stock')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_products');
    }
};
