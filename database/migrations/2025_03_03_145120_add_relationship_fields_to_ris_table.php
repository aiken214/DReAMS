<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ris', function (Blueprint $table) {
                             
            // $table->unsignedBigInteger('iar_id')->nullable();
            $table->foreign('iar_id', 'iar_fk_6936850')
                ->references('id')->on('iars')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->foreign('purchase_order_id', 'purchase_order_fk_7936835')
                ->references('id')->on('purchase_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('asset_id')->nullable();
            $table->foreign('asset_id', 'asset_fk_6936851')
                ->references('id')->on('assets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('donation_id')->nullable();
            $table->foreign('donation_id', 'donation_fk_6936852')
                ->references('id')->on('donations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

};
