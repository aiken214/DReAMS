<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPpmpsTable extends Migration
{
    public function up()
    {
        Schema::table('ppmps', function (Blueprint $table) {

            $table->unsignedBigInteger('fund_id')->nullable();
            $table->foreign('fund_id', 'fund_fk_3935001')
                  ->references('id')->on('fund_allocations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            $table->unsignedBigInteger('app_id')->nullable();
            $table->foreign('app_id', 'app_fk_6935003')
                  ->references('id')->on('apps')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            $table->unsignedBigInteger('station_id')->nullable();
            $table->foreign('station_id', 'station_fk_6935004')
                  ->references('id')->on('stations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

        });
    }

}
