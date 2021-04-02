<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackinglistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packinglists', function (Blueprint $table) {
            $table->increments('id');

            $table->string('fph');
            $table->string('hth')->nullable();
            $table->string('po')->nullable();
            $table->string('dpci')->nullable();
            $table->string('proname')->nullable();
            $table->integer('total_quantity')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('jx')->nullable();
            $table->integer('quantity_box')->nullable();
            $table->decimal('volume',8,2)->nullable();
            $table->decimal('gross_weight',8,2)->nullable();
            $table->decimal('gross_weight_perbox',8,2)->nullable();
            $table->decimal('net_weight',8,2)->nullable();
            $table->decimal('net_weight_prebox',8,2)->nullable();
            $table->string('factoryname')->nullable();
            $table->string('boxspec')->nullable();
            $table->string('boxno')->nullable();
            $table->date('date_vanning')->nullable();
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
        Schema::dropIfExists('packinglists');
    }
}
