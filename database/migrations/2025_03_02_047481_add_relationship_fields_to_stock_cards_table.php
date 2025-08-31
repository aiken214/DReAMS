<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_cards', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('iar_id')->nullable();
            $table->foreign('iar_id', 'iar_fk_6937145')
                ->references('id')->on('iars')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('iar_item_id')->nullable();
            $table->foreign('iar_item_id', 'iar_item_fk_6937245')
                ->references('id')->on('iar_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('asset_id')->nullable();
            $table->foreign('asset_id', 'asset_fk_6937615')
                ->references('id')->on('assets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('asset_item_id')->nullable();
            $table->foreign('asset_item_id', 'asset_item_fk_6937625')
                ->references('id')->on('asset_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('donation_id')->nullable();
            $table->foreign('donation_id', 'donation_fk_6937645')
                ->references('id')->on('donations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('donation_item_id')->nullable();
            $table->foreign('donation_item_id', 'donation_item_fk_6937655')
                ->references('id')->on('donation_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('rsmi_id')->nullable();
            $table->foreign('rsmi_id', 'rsmi_fk_1437615')
                ->references('id')->on('rsmis')
                ->onDelete('set null')
                ->onUpdate('cascade');

        });
    }

};
