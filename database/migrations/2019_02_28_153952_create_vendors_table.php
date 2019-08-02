<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');

            $table->string('number');
            $table->string('name');
            $table->string('contact_name1')->nullable();
            $table->string('contact_phone1')->nullable();
            $table->string('contact_name2')->nullable();
            $table->string('contact_phone2')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();

            $table->timestamps();

            $table->unique('number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
