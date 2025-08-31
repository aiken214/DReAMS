<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppItemssTable extends Migration
{
    
    public function up(): void
    {
        Schema::create('app_items', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('ppmp');
            $table->string('enduser');
            $table->string('epa');
            $table->string('mode')->nullable();
            $table->string('posting')->nullable();
            $table->string('opening')->nullable();
            $table->string('noa')->nullable();
            $table->string('contract')->nullable();
            $table->string('fund_source');
            $table->string('amount');
            $table->string('mooe_budget')->nullable();
            $table->string('co_budget')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_items');
    }
};
