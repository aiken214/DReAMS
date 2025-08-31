<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('regppeis', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('par_id')->nullable();
            $table->foreign('par_id', 'par_fk_6937867')
                ->references('id')->on('pars')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->unsignedBigInteger('rrppe_id')->nullable();
            $table->foreign('rrppe_id', 'rrppe_fk_6937867')
                ->references('id')->on('rrppes')
                ->onDelete('cascade')
                ->onUpdate('cascade');                
            
        });
    }

};
