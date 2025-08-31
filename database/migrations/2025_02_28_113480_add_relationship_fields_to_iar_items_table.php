<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iar_items', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('purchase_order_item_id')->nullable();
            $table->foreign('purchase_order_item_id', 'purchase_order_item_fk_7937125')
                ->references('id')->on('purchase_order_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('iar_id')->nullable();
            $table->foreign('iar_id', 'iar_fk_6936762')
                ->references('id')->on('iars')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

};
