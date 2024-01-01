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
        Schema::create('drugs', function (Blueprint $table) {
            $table->id('DRUG_ID');
            $table->string('NAME');
            $table->string('TYPE');
            $table->string('DOSE');
            $table->double('SELLING_PRICE');
            $table->date('EXPIRATION_DATE');
            $table->unsignedInteger('QUANTITY');
         
        });
    }

    public function down()
    {
        Schema::dropIfExists('drugs');
    }
};
