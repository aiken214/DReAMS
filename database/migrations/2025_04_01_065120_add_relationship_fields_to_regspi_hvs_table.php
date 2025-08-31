<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('regspi_hvs', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('ics_hv_id')->nullable();
            $table->foreign('ics_hv_id', 'ics_hv_fk_6936861')
                ->references('id')->on('ics_hvs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->unsignedBigInteger('rrsp_hv_id')->nullable();
            $table->foreign('rrsp_hv_id', 'rrsp_hv_fk_6936862')
                ->references('id')->on('rrsp_hvs')
                ->onDelete('cascade')
                ->onUpdate('cascade');                
            
        });
    }

};
