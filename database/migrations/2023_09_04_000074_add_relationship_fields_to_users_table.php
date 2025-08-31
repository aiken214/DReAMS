<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Adding 'position_id' foreign key referencing 'positions' table
            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id', 'position_fk_6935001')
                  ->references('id')->on('positions')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            // Adding 'station_id' foreign key referencing 'stations' table
            $table->unsignedBigInteger('station_id')->nullable();
            $table->foreign('station_id', 'station_fk_6958002')
                  ->references('id')->on('stations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

}
