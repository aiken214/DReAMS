<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAppItemsTable extends Migration
{
    public function up(): void
    {
        Schema::table('app_items', function (Blueprint $table) {

            $table->unsignedBigInteger('app_id')->nullable();
            $table->foreign('app_id', 'app_fk_8035245')
                  ->references('id')->on('apps')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->unsignedBigInteger('ppmp_id')->nullable();
            $table->foreign('ppmp_id', 'ppmp_fk_8035246')
                ->references('id')->on('ppmps')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                  
        });
    }

};
