<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id', 'position_fk_6935767')->references('id')->on('positions');
            $table->unsignedBigInteger('station_id')->nullable();
            $table->foreign('station_id', 'station_fk_6958202')->references('id')->on('stations');
        });
    }
}

