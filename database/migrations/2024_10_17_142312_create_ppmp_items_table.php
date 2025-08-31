<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpmpItemsTable extends Migration
{
    public function up(): void
    {
        Schema::create('ppmp_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('description', 10000)->nullable();
            $table->string('unit')->nullable();
            $table->string('quantity')->nullable();
            $table->string('balance')->nullable();
            $table->string('requested')->nullable();
            $table->string('cost')->nullable();
            $table->string('budget')->nullable();
            $table->string('mode')->nullable();
            $table->string('jan')->default(0);
            $table->string('feb')->default(0);
            $table->string('mar')->default(0);
            $table->string('apr')->default(0);
            $table->string('may')->default(0);
            $table->string('jun')->default(0);
            $table->string('jul')->default(0);
            $table->string('aug')->default(0);
            $table->string('sep')->default(0);
            $table->string('oct')->default(0);
            $table->string('nov')->default(0);
            $table->string('dec')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppmp_items');
    }
};
