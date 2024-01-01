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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('CUSTOMER_ID');
            $table->string('FIRST_NAME');
            $table->string('LAST_NAME');
            $table->date('DOB');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
