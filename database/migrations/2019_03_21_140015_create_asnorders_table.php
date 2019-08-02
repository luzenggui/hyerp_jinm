<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsnordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asnorders', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('asnshipment_id')->unsigned();
            $table->integer('pohead_id')->unsigned();

            $table->timestamps();

            $table->foreign('asnshipment_id')->references('id')->on('asnshipments')->onDelete('cascade');
            $table->foreign('pohead_id')->references('id')->on('poheads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asnorders');
    }
}
