<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpmpsTable extends Migration
{
    public function up(): void
    {
        Schema::create('ppmps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('calendar_year')->nullable();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('station')->nullable();
            $table->string('fund_source')->nullable();
            $table->string('budget_alloc')->nullable();
            $table->string('finalized')->nullable();
            $table->string('checked')->nullable();
            $table->string('verified')->nullable();
            $table->string('approved')->nullable();
            $table->string('added')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppmps');
    }
};
