<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkrecords', function (Blueprint $table) {
            $table->increments('id');
            $table->date('inputdate');
            $table->string('name');
            $table->string('telno');
            $table->string('department');
            $table->string('address');
            $table->decimal('temperature');
            $table->string('stuation_self')->nullable();
            $table->string('stuation_family')->nullable();
            $table->string('contactname_merg')->nullable();
            $table->string('contacttelno_merg')->nullable();
            $table->string('other_note')->nullable();
            $table->string('creator');
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
        Schema::dropIfExists('checkrecords');
    }
}
