<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ics_hvs', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('ris_id')->nullable();
            $table->foreign('ris_id', 'ris_fk_6936858')
                ->references('id')->on('ris')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
        });
    }

};
