<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterailsheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materialsheets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sheetno');
            $table->string('invoiceno')->nullable();
            $table->integer('type');
            $table->integer('mtid');
            $table->decimal('qty');
            $table->decimal('unitprice',8,2)->nullable();
            $table->decimal('amount',8,2)->nullable();
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
        Schema::dropIfExists('materialsheets');
    }
}
