<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderprocessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderprocesses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orderid');
            $table->integer('processid');
            $table->decimal('price',8,2)->nullable()->default(0);
            $table->timestamps();

            $table->foreign('processid')->references('id')->on('processes');
            $table->foreign('orderid')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderprocesses');
    }
}
