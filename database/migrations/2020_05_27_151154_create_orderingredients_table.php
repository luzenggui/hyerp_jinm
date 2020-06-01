<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderingredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderingredients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orderid');
            $table->integer('ingredientid');
            $table->decimal('price',8,2)->nullable()->default(0);
            $table->decimal('qty',8,2)->nullable()->default(0);
            $table->decimal('total_qty',8,2)->nullable()->default(0);
            $table->decimal('total_price',8,2)->nullable()->default(0);
            $table->string('ingredient_desc')->nullable();
            $table->string('remark_factory')->nullable();
            $table->timestamps();

            $table->foreign('ingredientid')->references('id')->on('ingredients');
            $table->foreign('orderid')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderingredients');
    }
}
