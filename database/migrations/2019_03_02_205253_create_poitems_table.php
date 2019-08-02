<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poitems', function (Blueprint $table) {
            $table->increments('id');

//            $table->integer('status')->default(0);
            $table->integer('pohead_id')->nullable();
            $table->integer('poitemc_id')->nullable();
//            $table->date('duedate')->nullable();
            $table->decimal('quantity', 18, 4)->default(0.0);
            $table->decimal('quantityreceived', 18, 4)->default(0.0);
            $table->string('chinesedescrip')->nullable();
            $table->decimal('unitprice', 18, 4)->nullable();
            $table->string('remark')->nullable();
//            $table->decimal('freight', 16, 4)->default(0.0);

            $table->timestamps();

            $table->foreign('pohead_id')->references('id')->on('poheads')->onDelete('cascade');
            $table->foreign('poitemc_id')->references('id')->on('poitemcs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poitems');
    }
}
