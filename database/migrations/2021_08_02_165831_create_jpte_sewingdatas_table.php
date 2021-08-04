<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJpteSewingdatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jpte_sewingdatas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('uploaddate');
            $table->string('shiftno');
            $table->string('name')->nullable();
            $table->string('machineno')->nullable();
            $table->integer('working_machines')->nullable();
            $table->decimal('efficiency',8,4)->nullable();
            $table->decimal('production')->nullable();
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
        Schema::dropIfExists('jpte_sewingdatas');
    }
}
