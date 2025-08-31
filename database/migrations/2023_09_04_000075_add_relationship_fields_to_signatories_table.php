<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSignatoriesTable extends Migration
{
    public function up()
    {
        Schema::table('signatories', function (Blueprint $table) {
           
            // Adding 'station_id' foreign key referencing 'stations' table
            $table->unsignedBigInteger('station_id')->nullable();
            $table->foreign('station_id', 'station_fk_6958012')
                  ->references('id')->on('stations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

}
