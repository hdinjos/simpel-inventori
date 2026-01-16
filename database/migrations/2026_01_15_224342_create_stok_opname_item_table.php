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
        Schema::create('stock_opname_item', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('stock_opname_id');
            $table->bigInteger('product_id');
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stock_opname_id')->references('id')->on('stock_opname')
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
        Schema::dropIfExists('stock_opname_item');
    }
};
