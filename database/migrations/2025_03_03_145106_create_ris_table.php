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
        Schema::create('ris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date')->nullable();
            $table->string('ris_no')->nullable();
            $table->string('recipient')->nullable();
            $table->string('designation')->nullable();
            $table->string('office')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('employee_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ris');
    }
};
