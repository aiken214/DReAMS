<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPurchaseRequestItemsTable extends Migration
{
    public function up()
    {
        Schema::table('purchase_request_items', function (Blueprint $table) {
            
            $table->unsignedBigInteger('purchase_request_id')->nullable();
            $table->foreign('purchase_request_id', 'purchase_request_fk_7935124')
                  ->references('id')->on('purchase_requests')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            $table->unsignedBigInteger('ppmp_item_id')->nullable();
            $table->foreign('ppmp_item_id', 'ppmp_item_fk_6935501')
                ->references('id')->on('ppmp_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // $table->unsignedBigInteger('purchase_order_item_id')->nullable();
            // $table->foreign('purchase_order_item_id', 'purchase_order_item_fk_7935125')
            //       ->references('id')->on('purchase_order_items')
            //       ->onDelete('cascade')
            //       ->onUpdate('cascade');

        });
    }

}
