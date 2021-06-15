<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJpteDefectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jpte_defects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lineno');
            $table->string('supervisor')->nullable();
            $table->string('customer')->nullable();
            $table->string('styleno')->nullable();
            $table->date('sewing_start_date')->nullable();
            $table->integer('check_qty')->nullable();
            $table->integer('pass_inspection_output')->nullable();
            $table->integer('broken_stitch')->nullable();
            $table->integer('skip_stitch')->nullable();
            $table->integer('uneven')->nullable();
            $table->integer('uncut_threads')->nullable();
            $table->integer('damage')->nullable();
            $table->integer('unparallel_joint')->nullable();
            $table->integer('puckering')->nullable();
            $table->integer('wrong_label')->nullable();
            $table->integer('dirt_oil_stain')->nullable();
            $table->integer('raw_edge')->nullable();
            $table->integer('colour_shading')->nullable();
            $table->integer('wrong_size')->nullable();
            $table->integer('side_seam')->nullable();
            $table->integer('holes')->nullable();
            $table->integer('off_shape')->nullable();
            $table->integer('uneven_guage')->nullable();
            $table->integer('misposition_buttons')->nullable();
            $table->integer('box_slant')->nullable();
            $table->integer('uneven_heat_seal')->nullable();
            $table->integer('open_seam')->nullable();
            $table->integer('hilow')->nullable();
            $table->integer('others')->nullable();
            $table->integer('others1')->nullable();
            $table->integer('others2')->nullable();
            $table->integer('others3')->nullable();
            $table->integer('others4')->nullable();
            $table->integer('others5')->nullable();
            $table->integer('total_defects')->nullable();
            $table->decimal('defetsrate',4,2)->nullable();
            $table->integer('finishing_return')->nullable();
            $table->decimal('finishing_returnrate',4,2)->nullable();
            $table->integer('defectsheet_id');
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
        Schema::dropIfExists('jpte_defects');
    }
}
