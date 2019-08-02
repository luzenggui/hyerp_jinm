<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipmentitems', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('shipment_id')->unsigned();
            $table->string('contract_number');
            $table->string('purchaseorder_number')->nullable();
            $table->decimal('qty_for_customer')->nullable();
            $table->decimal('amount_for_customer')->nullable();
            $table->decimal('volume')->nullable();

            $table->timestamps();

            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
//            $table->unique('contract_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipmentitems');
    }
}
