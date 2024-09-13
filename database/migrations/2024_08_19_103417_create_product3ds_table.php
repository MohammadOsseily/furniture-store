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
        if(!Schema::hasTable("product3ds")){
            Schema::create('product3ds', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_id');
                $table->string('model_file_path');
                $table->json('position')->default(json_encode(['x' => 0, 'y' => 0, 'z' => 0]));
                $table->json('scale')->default(json_encode(['x' => 3, 'y' => 3, 'z' => 3]));
                $table->json('rotation')->default(json_encode(['x' => 0, 'y' => 0, 'z' => 0]));
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product3ds');
    }
};
