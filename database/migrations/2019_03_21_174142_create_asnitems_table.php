<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsnitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asnitems', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('asnpackaging_id')->unsigned();
            $table->integer('poitemroll_id')->unsigned();

//            $table->decimal('quantity_shipped');
//            $table->decimal('gross_weight');
//            $table->string('gross_unit');
//            $table->decimal('fabric_width')->default(0.0);
//            $table->string('fabric_unit')->nullable();
//            $table->string('qa_status')->default('ACCEPT');     // ACCEPT, LOG
//            $table->decimal('net_weight');
//            $table->string('net_unit');
//            $table->string('ucc_number');
//            $table->integer('roll_number');
//            $table->string('remark')->nullable()->default('');


            $table->timestamps();

            $table->foreign('asnpackaging_id')->references('id')->on('asnpackagings')->onDelete('cascade');
            $table->foreign('poitemroll_id')->references('id')->on('poitemrolls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asnitems');
    }
}
