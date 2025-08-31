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
        Schema::create('property_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('stock_no')->nullable();
            $table->string('description', 10000)->nullable();
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->string('status')->nullable();
            $table->string('unit')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('amount')->nullable();
            $table->string('receipt_quantity')->nullable();
            $table->string('balance_quantity')->nullable();
            $table->string('issued_quantity')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
