<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFundObligationsTable extends Migration
{
    public function up(): void
    {
        Schema::table('fund_obligations', function (Blueprint $table) {

            $table->unsignedBigInteger('fund_id')->nullable();
            $table->foreign('fund_id', 'fund_fk_4935002')
                  ->references('id')->on('fund_allocations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->foreign('purchase_order_id', 'purchase_order_fk_7936762')
                ->references('id')->on('purchase_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

};
