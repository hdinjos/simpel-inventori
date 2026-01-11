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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->bigInteger('transaction_id');
            $table->bigInteger('product_id');
            $table->integer('quantity');
            $table->string('source_type')->nullable(true); //'package|single'
            $table->bigInteger('source_id')->nullable(true); //'package_id|null'
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('transactions')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('product_id')->references('id')->on('products')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
