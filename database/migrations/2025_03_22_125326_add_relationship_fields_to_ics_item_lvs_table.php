<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ics_item_lvs', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('ics_lv_id')->nullable();
            $table->foreign('ics_lv_id', 'ics_lv_fk_6936878')
                ->references('id')->on('ics_lvs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('ris_item_id')->nullable();
            $table->foreign('ris_item_id', 'ris_item_fk_6936889')
                ->references('id')->on('ris_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('semi_expendable_card_id')->nullable();
            $table->foreign('semi_expendable_card_id', 'semi_expendable_card_fk_6936888')
                ->references('id')->on('semi_expendable_cards')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // $table->unsignedBigInteger('rrsp_id')->nullable();
            // $table->foreign('rrsp_id', 'rrsp_fk_0236824')
            //     ->references('id')->on('rrsps')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');
            
        });
    }

};
