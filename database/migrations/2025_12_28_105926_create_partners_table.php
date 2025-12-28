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
        Schema::create('partners', function (Blueprint $table) {
            $table->bigInteger('id')->primary;
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->boolean('active');
            $table->bigInteger('partner_type_id');
            $table->timestamps();
            $table->foreign('partner_type_id')->references('id')->on('partner_types')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
