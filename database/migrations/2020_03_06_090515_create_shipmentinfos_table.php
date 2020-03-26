<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipmentinfos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('department');
            $table->string('custname');
            $table->string('invoiceno');
            $table->string('pono')->nullable();
            $table->integer('qty_bg')->nullable()->default(0);
            $table->decimal('amount_bg',12,2)->nullable()->default(0);
            $table->integer('qty_yf')->nullable()->default(0);
            $table->decimal('amount_yf',12,2)->nullable()->default(0);
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
        Schema::dropIfExists('shipmentinfos');
    }
}
