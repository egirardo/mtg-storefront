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
        Schema::create('sealed_products', function (Blueprint $table) {
            $table->unsignedInteger('product_id')->primary();
            $table->string('set_name', 50)->nullable();
<<<<<<< factories-seeders
            $table->timestamps();
=======
            $table->string('product_type_sealed', 50)->nullable();
>>>>>>> dev
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sealed_products');
    }
};
