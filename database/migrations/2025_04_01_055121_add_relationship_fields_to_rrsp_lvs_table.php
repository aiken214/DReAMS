<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rrsp_lvs', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('ics_lv_id')->nullable();
            $table->foreign('ics_lv_id', 'ics_lv_fk_6936869')
                ->references('id')->on('ics_lvs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
        });
    }

};
