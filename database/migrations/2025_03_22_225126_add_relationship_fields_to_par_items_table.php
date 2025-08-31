<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('par_items', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('par_id')->nullable();
            $table->foreign('par_id', 'par_fk_6936872')
                ->references('id')->on('pars')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('ris_item_id')->nullable();
            $table->foreign('ris_item_id', 'ris_item_fk_6936882')
                ->references('id')->on('ris_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('property_card_id')->nullable();
            $table->foreign('property_card_id', 'property_card_fk_6936886')
                ->references('id')->on('property_cards')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // $table->unsignedBigInteger('rrsp_id')->nullable();
            // $table->foreign('rrsp_id', 'rrsp_fk_1236824')
            //     ->references('id')->on('rrsps')
            //     ->onDelete('set null')
            //     ->onUpdate('cascade');
            
            $table->unsignedBigInteger('rpcppe_id')->nullable();
            $table->foreign('rpcppe_id', 'rpcppe_fk_6946264')
                ->references('id')->on('rpcppes')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

};
