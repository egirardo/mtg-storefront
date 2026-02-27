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
        Schema::create('singles_products', function (Blueprint $table) {
            $table->unsignedInteger('product_id')->primary();
            $table->string('rarity', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('number', 50)->nullable();
            $table->string('set_name', 50)->nullable();
            $table->timestamps();
            $table->string('set_name_single', 50)->nullable();
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('singles_products');
    }
};
