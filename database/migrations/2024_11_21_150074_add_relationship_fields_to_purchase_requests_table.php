<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPurchaseRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('purchase_requests', function (Blueprint $table) {

            $table->unsignedBigInteger('fund_id')->nullable();
            $table->foreign('fund_id', 'fund_fk_3935002')
                  ->references('id')->on('fund_allocations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            $table->unsignedBigInteger('station_id')->nullable();
            $table->foreign('station_id', 'station_fk_6935024')
                  ->references('id')->on('stations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->unsignedBigInteger('ppmp_id')->nullable();
            $table->foreign('ppmp_id', 'ppmp_fk_6935134')
                ->references('id')->on('ppmps')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

}
