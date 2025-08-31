<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ics_item_hvs', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('ics_hv_id')->nullable();
            $table->foreign('ics_hv_id', 'ics_hv_fk_6936858')
                ->references('id')->on('ics_hvs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('ris_item_id')->nullable();
            $table->foreign('ris_item_id', 'ris_item_fk_6936880')
                ->references('id')->on('ris_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('semi_expendable_card_id')->nullable();
            $table->foreign('semi_expendable_card_id', 'semi_expendable_card_fk_6936884')
                ->references('id')->on('semi_expendable_cards')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // $table->unsignedBigInteger('rrsp_id')->nullable();
            // $table->foreign('rrsp_id', 'rrsp_fk_0236824')
            //     ->references('id')->on('rrsps')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');
            
            $table->unsignedBigInteger('rpcsp_id')->nullable();
            $table->foreign('rpcsp_id', 'rpcsp_fk_6946369')
                ->references('id')->on('rpcsps')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

};
