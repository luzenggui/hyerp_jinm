<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummaryDefectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summary_defects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('defectsheet_id');
            $table->string('buyer');
            $table->integer('washingrepair_qty');
            $table->decimal('washingrepair_rate',4,2);
            $table->integer('sewingrepair_qty');
            $table->decimal('sewingrepair_rate',4,2);
            $table->integer('total_repair');
            $table->integer('good_pcs');
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
        Schema::dropIfExists('summary_defects');
    }
}
