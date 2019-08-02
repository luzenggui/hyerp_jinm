<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsnpackagingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asnpackagings', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('asnorder_id')->unsigned();
            $table->integer('poitem_id')->unsigned();
            $table->string('dyelotseries')->default('A');
            $table->string('packaging_code')->default('ROL');
            $table->decimal('free_quantity', 18, 3)->default(0.0);

            $table->timestamps();

            $table->foreign('asnorder_id')->references('id')->on('asnorders')->onDelete('cascade');
            $table->foreign('poitem_id')->references('id')->on('poitems');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asnpackagings');
    }
}
