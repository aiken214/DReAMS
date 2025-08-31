<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asset_items', function (Blueprint $table) {

            $table->unsignedBigInteger('asset_id')->nullable();
            $table->foreign('asset_id', 'asset_fk_6936774')
                ->references('id')->on('assets')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

};
