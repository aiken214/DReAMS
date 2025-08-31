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
        Schema::create('rpcis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('article')->nullable();
            $table->string('description', 10000)->nullable();
            $table->string('stock_no')->nullable();
            $table->string('type')->nullable();
            $table->string('unit')->nullable();
            $table->string('unit_value')->nullable();
            $table->string('quantity_property_card')->nullable();
            $table->string('quantity_physical_count')->nullable();
            $table->string('quantity_so')->nullable();
            $table->string('value_so')->nullable();
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
        Schema::dropIfExists('rpcis');
    }
};
