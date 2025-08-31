<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPurchaseOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {

            $table->unsignedBigInteger('purchase_request_id')->nullable();
            $table->foreign('purchase_request_id', 'purchase_request_fk_7935245')
                  ->references('id')->on('purchase_requests')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id', 'supplier_fk_6935634')
                ->references('id')->on('suppliers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

};
