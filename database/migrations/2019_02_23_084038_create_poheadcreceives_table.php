<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoheadcreceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poheadcreceives', function (Blueprint $table) {
            $table->increments('id');

            $table->string('interchange_sender_id');
            $table->string('interchange_receiver_id');
            $table->dateTime('interchange_datetime');
            $table->string('interchange_control_number');
            $table->string('test_indicator');       // T:Test Data; P:Production Data
            $table->dateTime('data_interchange_datetime');
            $table->string('transaction_set_control_no');
            $table->string('transaction_set_purpose_code');     // '00': Original; '18': Revised; '01': Cancel
            $table->string('purchase_order_number');
            $table->integer('release_number');
            $table->date('po_extract_date');
            $table->string('currency_code');
            $table->decimal('exchange_rate', 18, 4)->default(1.0);
            $table->string('po_type');
            $table->string('product_type');
            $table->string('weave_type');
            $table->string('salesman_name');
            $table->string('origin_country');
            $table->string('export_country');
            $table->string('destination_country');
            $table->string('incoterms');
            $table->string('incoterms_code');
            $table->integer('payment_days')->default(1);
            $table->string('payment_term');
            $table->string('manufacturing_method');
            $table->string('packing_instruction');
            $table->string('remark', 4000);
            $table->string('payee_name')->nullable();
            $table->string('payee_code')->nullable();
            $table->string('supplier_name');
            $table->string('supplier_code');
            $table->string('ship_to');
            $table->string('factory_code');
            $table->string('ship_to_address1');
            $table->string('ship_to_address2')->nullable();
            $table->string('country_of_consignee');
            $table->string('buyer_name');
            $table->string('buyer_code');
            $table->string('garment_customer_name');
            $table->string('garment_customer_code');
            $table->integer('number_of_line_items')->default(0);

            $table->smallInteger('status')->default(0)->comment('0: 正常同步到poheadcs; -1: poheadcs已存在此订单且已分单');              // 0: 正常同步到poheadcs; -1: poheadcs已存在此订单且已分单; -2: 取消PO

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
        Schema::dropIfExists('poheadcs');
    }
}
