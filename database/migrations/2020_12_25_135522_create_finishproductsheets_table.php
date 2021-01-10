<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinishproductsheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finishproductsheets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoiceno')->nullable();
            $table->string('sheetno');
            $table->integer('type');
            $table->string('patt');
            $table->string('color');
            $table->integer('fgid');
            $table->decimal('qty');
            $table->decimal('unitprice',8,2)->nullable();
            $table->decimal('amount',8,2)->nullable();
            $table->decimal('cmunitprice',8,2)->nullable();
            $table->decimal('cmamount',8,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finishproductsheets');
    }
}
