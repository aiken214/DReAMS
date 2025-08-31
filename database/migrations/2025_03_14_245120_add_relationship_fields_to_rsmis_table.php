<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rsmis', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('ris_id')->nullable();
            $table->foreign('ris_id', 'ris_fk_6946875')
                ->references('id')->on('ris')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->foreign('purchase_order_id', 'purchase_order_fk_7936845')
                ->references('id')->on('purchase_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('donation_id')->nullable();
            $table->foreign('donation_id', 'donation_fk_6936856')
                ->references('id')->on('donations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
        });
    }

};
