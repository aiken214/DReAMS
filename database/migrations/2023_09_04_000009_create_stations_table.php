<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationsTable extends Migration
{
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('station_id')->nullable();
            $table->string('station_name')->nullable();
            $table->string('category')->nullable();
            $table->string('accountable_officer')->nullable();
            $table->string('position')->nullable();
            $table->string('assumed_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
