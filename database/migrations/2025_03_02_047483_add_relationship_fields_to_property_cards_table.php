<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('iar_id')->nullable();
            $table->foreign('iar_id', 'iar_fk_6937165')
                ->references('id')->on('iars')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('iar_item_id')->nullable();
            $table->foreign('iar_item_id', 'iar_item_fk_6937255')
                ->references('id')->on('iar_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('asset_id')->nullable();
            $table->foreign('asset_id', 'asset_fk_6937815')
                ->references('id')->on('assets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('asset_item_id')->nullable();
            $table->foreign('asset_item_id', 'asset_item_fk_6937825')
                ->references('id')->on('asset_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('donation_id')->nullable();
            $table->foreign('donation_id', 'donation_fk_6937845')
                ->references('id')->on('donations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('donation_item_id')->nullable();
            $table->foreign('donation_item_id', 'donation_item_fk_6937855')
                ->references('id')->on('donation_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('rpcppe_id')->nullable();
            $table->foreign('rpcppe_id', 'rpcppe_fk_6946269')
                ->references('id')->on('rpcppes')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

};
