<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iars', function (Blueprint $table) {
                             
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->foreign('purchase_order_id', 'purchase_order_fk_7936825')
                ->references('id')->on('purchase_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('purchase_request_id')->nullable();
            $table->foreign('purchase_request_id', 'purchase_request_fk_7936855')
                ->references('id')->on('purchase_requests')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id', 'supplier_fk_6935725')
                ->references('id')->on('suppliers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

};
