<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\TransactionType;
use App\Enums\TransactionStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('identifier')->unique(); //TRX-month-year-number-incrementing
            $table->bigInteger('user_id');
            $table->bigInteger('partner_id');
            $table->enum('type', TransactionType::cases()); // in | out
            $table->text('note');
            $table->enum('status', TransactionStatus::cases());
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('partner_id')->references('id')->on('partners')
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
        Schema::dropIfExists('transactions');
    }
};
