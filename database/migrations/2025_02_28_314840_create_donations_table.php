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
        Schema::create('donations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date')->nullable();
            $table->string('donation_no')->nullable();
            $table->string('reference')->nullable();
            $table->string('donor')->nullable();
            $table->string('purpose')->nullable();
            $table->string('requester')->nullable();
            $table->string('designation')->nullable();
            $table->string('office')->nullable();
            $table->string('supplier')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
