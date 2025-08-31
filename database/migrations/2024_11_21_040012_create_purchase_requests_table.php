<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestsTable extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date')->nullable();
            $table->string('pr_no')->nullable();
            $table->string('res_code')->nullable();
            $table->string('fund_cluster')->nullable();
            $table->string('fund_source')->nullable();
            $table->string('purpose', 1000)->nullable();
            $table->string('office')->nullable();
            $table->string('requested_by')->nullable();
            $table->string('designation')->nullable();
            $table->string('file')->nullable();
            $table->string('finalized')->nullable();
            $table->string('checked')->nullable();
            $table->string('pre_check')->nullable();
            $table->string('verified')->nullable();
            $table->string('approved')->nullable();
            $table->string('added')->nullable();
            $table->string('quoted')->nullable();
            $table->string('served')->nullable();
            $table->string('delivered')->nullable();
            $table->string('remarks')->nullable();
            $table->string('petty_cash_iar_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
