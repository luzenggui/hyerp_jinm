<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessdetailsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inquiry_sheetid');
            $table->integer('processid');
            $table->decimal('price',8,2)->nullable()->default(0);
            $table->timestamps();

            $table->foreign('processid')->references('id')->on('processes');
            $table->foreign('inquiry_sheetid')->references('id')->on('inquiry_sheets');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processdetails');
    }
}
