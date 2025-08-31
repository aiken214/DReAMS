<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundAllocationsTable extends Migration
{
    
    public function up(): void
    {
        Schema::create('fund_allocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('fund_source')->nullable();
            $table->string('allotment_class')->nullable();
            $table->string('legal_basis')->nullable();
            $table->string('particulars', 500)->nullable();
            $table->string('amount')->nullable();
            $table->string('obligated')->nullable();
            $table->string('unobligated')->nullable();
            $table->string('ppa')->nullable();
            $table->string('appropriation')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fund_allocations');
    }
};
