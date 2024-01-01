<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('purchase_history', function (Blueprint $table) {
            $table->id('PURCHASE_ID');
            $table->unsignedBigInteger('CUSTOMER_ID');
            $table->unsignedBigInteger('DRUG_ID');
            $table->timestamp('PURCHASE_DATE')->default(now());
            $table->integer('QUANTITY_PURCHASED');
            $table->double('TOTAL_BILL');
    
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_history');
    }
};
