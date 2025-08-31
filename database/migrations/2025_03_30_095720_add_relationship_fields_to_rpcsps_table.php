<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rpcsps', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('ics_item_hv_id')->nullable();
            $table->foreign('ics_item_hv_id', 'ics_item_hv_fk_6946864')
                ->references('id')->on('ics_item_hvs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->unsignedBigInteger('station_id')->nullable();
            $table->foreign('station_id', 'station_fk_6946867')
                ->references('id')->on('stations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('iirusp_item_id')->nullable();
            $table->foreign('iirusp_item_id', 'iirusp_item_fk_1424140')
                ->references('id')->on('iirusp_items')
                ->onDelete('set null')
                ->onUpdate('cascade');  

        });
    }

};
