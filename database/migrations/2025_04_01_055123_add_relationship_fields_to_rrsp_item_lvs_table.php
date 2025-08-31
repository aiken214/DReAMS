<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rrsp_item_lvs', function (Blueprint $table) {

            $table->unsignedBigInteger('rrsp_lv_id')->nullable();
            $table->foreign('rrsp_lv_id', 'rrsp_lv_fk_0236828')
                ->references('id')->on('rrsp_lvs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('ics_item_lv_id')->nullable();
            $table->foreign('ics_item_lv_id', 'ics_item_lv_fk_6936892')
                ->references('id')->on('ics_item_lvs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('ris_item_id')->nullable();
            $table->foreign('ris_item_id', 'ris_item_fk_6936890')
                ->references('id')->on('ris_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('semi_expendable_card_id')->nullable();
            $table->foreign('semi_expendable_card_id', 'semi_expendable_card_fk_6936890')
                ->references('id')->on('semi_expendable_cards')
                ->onDelete('cascade')
                ->onUpdate('cascade');            
            
        });
    }

};
