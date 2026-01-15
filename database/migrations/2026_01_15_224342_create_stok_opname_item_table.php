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
        Schema::create('stok_opname_item', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('stok_opname_id');
            $table->bigInteger('product_id');
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stok_opname_id')->references('id')->on('stok_opname')
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
        Schema::dropIfExists('stok_opname_item');
    }
};
