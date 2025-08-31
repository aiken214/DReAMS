<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToRequestForQuotationTable extends Migration
{
    public function up(): void
    {
        Schema::table('request_for_quotations', function (Blueprint $table) {

            $table->unsignedBigInteger('purchase_request_id')->nullable();
            $table->foreign('purchase_order_id', 'purchase_request_fk_7936456')
                ->references('id')->on('purchase_requests')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

};
