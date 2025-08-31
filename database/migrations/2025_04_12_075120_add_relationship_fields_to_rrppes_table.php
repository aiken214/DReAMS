<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rrppes', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('par_id')->nullable();
            $table->foreign('par_id', 'par_fk_6936869')
                ->references('id')->on('pars')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
        });
    }

};
