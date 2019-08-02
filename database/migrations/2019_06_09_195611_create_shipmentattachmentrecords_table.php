<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentattachmentrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipmentattachmentrecords', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('shipment_id');
            $table->string('type')->nullable();
            $table->string('filename')->nullable();
            $table->string('path')->nullable();
            $table->string('operation_type')->nullable();
            $table->string('operator')->nullable();

            $table->timestamps();

            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipmentattachmentrecords');
    }
}
