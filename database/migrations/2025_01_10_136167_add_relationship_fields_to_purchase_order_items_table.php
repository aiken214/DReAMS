<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPurchaseOrderItemsTable extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {

            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->foreign('purchase_order_id', 'purchase_order_fk_7936425')
                ->references('id')->on('purchase_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->unsignedBigInteger('purchase_request_item_id')->nullable();
            $table->foreign('purchase_request_item_id', 'purchase_request_item_fk_6935668')
                ->references('id')->on('purchase_request_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

};
