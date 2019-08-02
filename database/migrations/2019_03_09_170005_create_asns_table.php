<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asns', function (Blueprint $table) {
            $table->increments('id');

//            $table->string('number')->nullable();

//            $table->string('interchange_sender_id');
//            $table->string('interchange_receiver_id');
            $table->dateTime('interchange_datetime');
            $table->string('interchange_control_number');
            $table->string('test_indicator');       // T:Test Data; P:Production Data
            $table->dateTime('data_interchange_datetime');
            $table->string('transaction_set_control_no');
//            $table->string('transaction_set_purpose_code')->default('00');     // '00': Original; '18': Revised; '01': Cancel, default: '00'
            $table->string('asn_number');

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
        Schema::dropIfExists('asns');
    }
}
