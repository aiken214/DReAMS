<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iirusp_items', function (Blueprint $table) {
    
            $table->unsignedBigInteger('iirusp_id')->nullable();
            $table->foreign('iirusp_id', 'iirusp_fk_1424148')
                ->references('id')->on('iirusps')
                ->onDelete('cascade')
                ->onUpdate('cascade');  

            $table->unsignedBigInteger('rpcsp_id')->nullable();
            $table->foreign('rpcsp_id', 'rpcsp_fk_6447148')
                ->references('id')->on('rpcsps')
                ->onDelete('cascade')
                ->onUpdate('cascade');    
            
        });
    }

};
