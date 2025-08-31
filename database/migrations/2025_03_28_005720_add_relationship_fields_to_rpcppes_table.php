<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rpcppes', function (Blueprint $table) {

            $table->unsignedBigInteger('station_id')->nullable();
            $table->foreign('station_id', 'station_fk_6946863')
                ->references('id')->on('stations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('par_item_id')->nullable();
            $table->foreign('par_item_id', 'par_item_fk_6946862')
                ->references('id')->on('par_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');               

            $table->unsignedBigInteger('iirup_item_id')->nullable();
            $table->foreign('iirup_item_id', 'iirup_item_fk_1424140')
                ->references('id')->on('iirup_items')
                ->onDelete('set null')
                ->onUpdate('cascade');  

        });
    }

};
