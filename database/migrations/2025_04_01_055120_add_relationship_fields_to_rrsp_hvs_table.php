<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rrsp_hvs', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('ics_hv_id')->nullable();
            $table->foreign('ics_hv_id', 'ics_hv_fk_6936865')
                ->references('id')->on('ics_hvs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
        });
    }

};
