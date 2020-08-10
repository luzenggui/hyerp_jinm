<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invno');
            $table->string('departno')->nullable();
            $table->string('customer')->nullable();
            $table->date('invdate')->nullable();
            $table->string('maker')->nullable();
            $table->string('productname')->nullable();
            $table->string('pono')->nullable();
            $table->string('factory')->nullable();
            $table->string('destination')->nullable();
            $table->date('shipdate')->nullable();
            $table->string('verification_no')->nullable();
            $table->string('shipcompany')->nullable();
            $table->string('shipno')->nullable();
            $table->string('paymethod')->nullable();
            $table->string('quantity')->nullable();
            $table->decimal('payamount_jintex',10,2)->nullable();
            $table->decimal('payamount_wuxi',10,2)->nullable();
            $table->date('fore_paydate')->nullable();
            $table->date('paydate')->nullable();
            $table->decimal('freight',10,2)->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
