<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPpmpItemsTable extends Migration
{
    public function up()
    {
        Schema::table('ppmp_items', function (Blueprint $table) {
            
            $table->unsignedBigInteger('ppmp_id')->nullable();
            $table->foreign('ppmp_id', 'ppmp_fk_6935004')
                  ->references('id')->on('ppmps')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->unsignedBigInteger('purchase_request_id')->nullable();
            $table->foreign('purchase_request_id', 'purchase_request_fk_6935106')
                  ->references('id')->on('purchase_requests')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

        });
    }

}
