<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iirusps', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('station_id')->nullable();
            $table->foreign('station_id', 'station_fk_6937889')
                ->references('id')->on('stations')
                ->onDelete('cascade')
                ->onUpdate('cascade');            
            
        });
    }

};
