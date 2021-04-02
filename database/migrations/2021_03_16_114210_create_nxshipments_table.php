<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNxshipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nxshipments', function (Blueprint $table) {
            $table->increments('id');

            $table->string('customer_name')->nullable();
            $table->string('invoice_number');
            $table->string('contract_number')->nullable();
            $table->date('cyrq')->nullable();
            $table->decimal('cybd')->nullable();
            $table->decimal('amount_shipments')->nullable();
            $table->decimal('amount_hjkp')->nullable();
            $table->decimal('amount_hjsk')->nullable();
            $table->string('note')->nullable();
            $table->decimal('amount_kp1')->nullable();
            $table->date('date_kp1')->nullable();
            $table->decimal('amount_kp2')->nullable();
            $table->date('date_kp2')->nullable();
            $table->decimal('amount_kp3')->nullable();
            $table->date('date_kp3')->nullable();
            $table->decimal('amount_kp4')->nullable();
            $table->date('date_kp4')->nullable();
            $table->decimal('amount_kp5')->nullable();
            $table->date('date_kp5')->nullable();
            $table->decimal('amount_sk1')->nullable();
            $table->date('date_sk1')->nullable();
            $table->decimal('amount_sk2')->nullable();
            $table->date('date_sk2')->nullable();
            $table->decimal('amount_sk3')->nullable();
            $table->date('date_sk3')->nullable();
            $table->decimal('amount_sk4')->nullable();
            $table->date('date_sk4')->nullable();
            $table->decimal('amount_sk5')->nullable();
            $table->date('date_sk5')->nullable();
            $table->string('note1')->nullable();

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
        Schema::dropIfExists('nxshipments');
    }
}
