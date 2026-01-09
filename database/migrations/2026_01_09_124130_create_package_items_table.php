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
        Schema::create('package_items', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->integer('quantity');
            $table->bigInteger('package_id');
            $table->bigInteger('product_id');
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('product_id')->references('id')->on('products')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_items');
    }
};
