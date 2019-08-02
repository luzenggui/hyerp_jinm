<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoitemrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poitemrolls', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('poitem_id')->unsigned();
            $table->integer('roll_number');
            $table->decimal('quantity_shipped');
            $table->decimal('gross_weight');
            $table->string('gross_unit')->default('KG');
            $table->decimal('fabric_width')->default(0.0);
            $table->string('fabric_unit')->default('IN');
            $table->string('qa_status')->default('ACCEPT');     // ACCEPT, LOG
            $table->decimal('net_weight');
            $table->string('net_unit')->default('KG');
            $table->string('ucc_number');
            $table->string('remark')->nullable()->default('');
            $table->string('remark2')->nullable()->default('');
            $table->string('remark3')->nullable()->default('');

            $table->timestamps();

            $table->foreign('poitem_id')->references('id')->on('poitems');
            $table->unique(['poitem_id', 'roll_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poitemrolls');
    }
}
