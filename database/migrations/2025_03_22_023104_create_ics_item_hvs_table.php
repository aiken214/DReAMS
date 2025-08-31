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
        Schema::create('ics_item_hvs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->string('unit_cost')->nullable();
            $table->string('total_cost')->nullable();
            $table->string('description')->nullable();
            $table->string('inventory_item_no')->nullable();
            $table->string('lifespan')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('serviceability')->nullable();
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
        Schema::dropIfExists('ics_item_hvs');
    }
};
