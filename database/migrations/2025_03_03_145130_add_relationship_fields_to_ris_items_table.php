<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ris_items', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('ris_id')->nullable();
            $table->foreign('ris_id', 'ris_fk_6936865')
                ->references('id')->on('ris')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('stock_card_id')->nullable();
            $table->foreign('stock_card_id', 'stock_card_fk_6936867')
                ->references('id')->on('stock_cards')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('semi_expendable_card_id')->nullable();
            $table->foreign('semi_expendable_card_id', 'semi_expendable_card_fk_6936868')
                ->references('id')->on('semi_expendable_cards')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        
            $table->unsignedBigInteger('property_card_id')->nullable();
            $table->foreign('property_card_id', 'property_card_fk_6936869')
                ->references('id')->on('property_cards')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
        });
    }

};
