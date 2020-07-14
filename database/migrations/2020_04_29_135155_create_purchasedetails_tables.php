<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasedetailsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasedetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inquiry_sheetid');
            $table->integer('partid');
            $table->string('fabric_desc')->nullable();
            $table->string('composition')->nullable();
            $table->string('valid_width')->nullable();
            $table->string('edge_to_edge_width')->nullable();
            $table->decimal('qty',8,2)->nullable()->default(0);
            $table->decimal('price',8,2)->nullable()->default(0);
            $table->decimal('outprice',8,2)->nullable()->default(0);
            $table->decimal('total_qty',8,2)->nullable()->default(0);
            $table->decimal('total_price',8,2)->nullable()->default(0);
            $table->decimal('total_outprice',8,2)->nullable()->default(0);
            $table->string('factoryname')->nullable();
            $table->timestamps();

            $table->foreign('partid')->references('id')->on('parts');
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
        Schema::dropIfExists('purchasedetails');
    }
}
