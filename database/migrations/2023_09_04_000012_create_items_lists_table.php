<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsListsTable extends Migration
{
    public function up(): void
    {
        Schema::create('items_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_code')->nullable();
            $table->string('description')->nullable();
            $table->string('unit')->nullable();
            $table->string('price')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items_lists');
    }
};
