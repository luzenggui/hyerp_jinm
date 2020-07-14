<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customername');
            $table->string('prod_description')->nullable();
            $table->string('prod_photo');
            $table->string('prod_size');
            $table->string('customer_item_name')->nullable();
            $table->string('supplier_stock_number');
            $table->string('UPC')->nullable();
            $table->integer('prod_qty')->nullable()->default(1);
            $table->decimal('FOB_SH_price',8,2)->nullable();
            $table->string('ingredients_note')->nullable();
            $table->string('packing_note')->nullable();
            $table->string('remark_factory')->nullable();
            $table->decimal('process_costs')->nullable()->default(0);
            $table->decimal('process_taxcosts')->nullable()->default(0);
            $table->decimal('purchase_costs')->nullable()->default(0);
            $table->decimal('purchase_outcosts')->nullable()->default(0);
            $table->decimal('total_costs')->nullable()->default(0);
            $table->decimal('total_outcosts')->nullable()->default(0);
            $table->string('remark')->nullable();
            $table->decimal('length_carton',5,2)->nullable()->default(0);
            $table->decimal('width_carton',5,2)->nullable()->default(0);
            $table->decimal('high_carton',5,2)->nullable()->default(0);
            $table->integer('qty_percarton')->nullable()->default(0);
            $table->decimal('vol_total',8,2)->nullable()->default(0);
            $table->integer('qty_container')->nullable()->default(0);
            $table->decimal('inland_freight',8,2)->nullable()->default(0);
            $table->decimal('arlington_ocean_freight',8,2)->nullable()->default(0);
            $table->decimal('atc_ocean_freight',8,2)->nullable()->default(0);
            $table->decimal('risk_rate',4,2)->nullable()->default(0);
            $table->decimal('fob_shanghai',8,2)->nullable()->default(0);
            $table->decimal('import_rate',6,3)->nullable()->default(0);
            $table->decimal('arlington_ldp',8,2)->nullable()->default(0);
            $table->decimal('atc_ldp',8,2)->nullable()->default(0);
            $table->decimal('process_tax',8,2)->nullable()->default(0);
            $table->decimal('exchange_rate',5,2)->nullable()->default(0);
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
        Schema::dropIfExists('orders');
    }
}
