<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuttingDefectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cutting_defects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('defectsheet_id');
            $table->string('cutting_name');
            $table->decimal('cutting_qty',8,2);
            $table->decimal('defect_qty',8,2);
            $table->decimal('cutting_defectsrate',4,2);
            $table->string('cutting_note');
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
        Schema::dropIfExists('cutting_defects');
    }
}
