<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinishingDefectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finishing_defects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('defectsheet_id');
            $table->string('finishing_name');
            $table->integer('finishing_qty');
            $table->decimal('finishing_rate',4,2);
            $table->timestamps();

            $table->foreign('defectsheet_id')->references('id')->on('jpteheads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finishing_defects');
    }
}
