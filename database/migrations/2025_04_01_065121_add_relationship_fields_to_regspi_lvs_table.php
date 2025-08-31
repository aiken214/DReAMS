<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('regspi_lvs', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('ics_lv_id')->nullable();
            $table->foreign('ics_lv_id', 'ics_lv_fk_6936867')
                ->references('id')->on('ics_lvs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->unsignedBigInteger('rrsp_lv_id')->nullable();
            $table->foreign('rrsp_lv_id', 'rrsp_lv_fk_6936868')
                ->references('id')->on('rrsp_lvs')
                ->onDelete('cascade')
                ->onUpdate('cascade');                
            
        });
    }

};
