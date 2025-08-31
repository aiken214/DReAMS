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
        Schema::create('iirup_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date_acquired')->nullable();
            $table->string('particulars', 10000)->nullable();
            $table->string('property_no')->nullable();
            $table->string('quantity')->nullable();
            $table->string('unit_cost')->nullable();
            $table->string('total_cost')->nullable();
            $table->string('depreciation')->nullable();
            $table->string('losses')->nullable();
            $table->string('carrying_amount')->nullable();
            $table->string('remarks')->nullable();
            $table->string('sale')->nullable();
            $table->string('transfer')->nullable();
            $table->string('destruction')->nullable();
            $table->string('others')->nullable();
            $table->string('total_dispose')->nullable();
            $table->string('appraised_value')->nullable();
            $table->string('or_no')->nullable();
            $table->string('amount')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iirup_items');
    }
};
