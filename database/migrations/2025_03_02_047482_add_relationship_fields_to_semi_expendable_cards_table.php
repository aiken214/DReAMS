<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('semi_expendable_cards', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('iar_id')->nullable();
            $table->foreign('iar_id', 'iar_fk_6937155')
                ->references('id')->on('iars')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->unsignedBigInteger('iar_item_id')->nullable();
            $table->foreign('iar_item_id', 'iar_item_fk_6937250')
                ->references('id')->on('iar_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        
            $table->unsignedBigInteger('asset_id')->nullable();
            $table->foreign('asset_id', 'asset_fk_6937715')
                ->references('id')->on('assets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('asset_item_id')->nullable();
            $table->foreign('asset_item_id', 'asset_item_fk_6937725')
                ->references('id')->on('asset_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('donation_id')->nullable();
            $table->foreign('donation_id', 'donation_fk_6937745')
                ->references('id')->on('donations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('donation_item_id')->nullable();
            $table->foreign('donation_item_id', 'donation_item_fk_6937755')
                ->references('id')->on('donation_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('ics_lv_id')->nullable();
            $table->foreign('ics_lv_id', 'ics_lv_fk_2437635')
                ->references('id')->on('ics_lvs')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('ics_hv_id')->nullable();
            $table->foreign('ics_hv_id', 'ics_hv_fk_2437655')
                ->references('id')->on('ics_hvs')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('rpcsp_id')->nullable();
            $table->foreign('rpcsp_id', 'rpcsp_fk_6946270')
                ->references('id')->on('rpcsps')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

};
