<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iirup_items', function (Blueprint $table) {
    
            $table->unsignedBigInteger('iirup_id')->nullable();
            $table->foreign('iirup_id', 'iirup_fk_1424145')
                ->references('id')->on('iirups')
                ->onDelete('cascade')
                ->onUpdate('cascade');  

            $table->unsignedBigInteger('rpcppe_id')->nullable();
            $table->foreign('rpcppe_id', 'rpcppe_fk_6447145')
                ->references('id')->on('rpcppes')
                ->onDelete('cascade')
                ->onUpdate('cascade');    
            
        });
    }

};
