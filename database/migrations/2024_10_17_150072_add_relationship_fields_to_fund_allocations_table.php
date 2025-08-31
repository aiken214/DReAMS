<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFundAllocationsTable extends Migration
{
    public function up()
    {
        Schema::table('fund_allocations', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_3735011')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

        });
    }

}
