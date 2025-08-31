<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donation_items', function (Blueprint $table) {

            $table->unsignedBigInteger('donation_id')->nullable();
            $table->foreign('donation_id', 'donation_fk_6936774')
                ->references('id')->on('donations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

};
