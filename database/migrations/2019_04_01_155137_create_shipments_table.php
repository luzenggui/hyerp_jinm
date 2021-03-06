<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->increments('id');

            $table->string('dept');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('invoice_number');
            $table->string('oversea_fty_ci_no')->nullable();
            $table->string('contract_number');
            $table->string('type')->nullable();
            $table->string('purchaseorder_number')->nullable();
            $table->string('depart_port')->nullable();
            $table->string('cargo_description')->nullable();
            $table->string('hs_code')->nullable();
            $table->string('processing_plant')->nullable();
            $table->string('trade_type')->nullable();
            $table->string('dest_country')->nullable();
            $table->string('dest_port')->nullable();
            $table->string('incoterm')->nullable();
            $table->string('ship_by')->nullable();
            $table->string('crd')->nullable();
            $table->date('dcd_date')->nullable();
            $table->string('container')->nullable();
            $table->string('forwarder')->nullable();
            $table->date('etd')->nullable();
            $table->date('eta')->nullable();
            $table->string('deliver_no')->nullable();
            $table->date('declaration_date')->nullable();
            $table->string('customs_declaratipages')->nullable();
            $table->string('customs_declaration_no')->nullable();
            $table->date('customs_declaration_return')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('issue_bank')->nullable();
            $table->string('issue_bank_address')->nullable();
            $table->string('issue_bank_swift')->nullable();
            $table->date('negotiation_ci_date')->nullable();
            $table->date('negotiation_date')->nullable();
            $table->date('tradecard_login_date')->nullable();
            $table->date('tradecard_confirmation_date')->nullable();
            $table->string('payment_by')->nullable();
            $table->decimal('qty_for_customs')->nullable();
            $table->decimal('amount_for_customs')->nullable();
            $table->decimal('qty_for_customer')->nullable();
            $table->decimal('amount_for_customer')->nullable();
            $table->decimal('amount_customer_payment')->nullable();
            $table->date('customer_payment_date')->nullable();
            $table->decimal('different_column_ao_vs_am')->nullable();
            $table->decimal('percent_different_column_ao_vs_am')->nullable();
            $table->decimal('first_sale')->nullable();
            $table->decimal('wuxi_obtain_amount')->nullable();
            $table->decimal('pmj_obtain_amount')->nullable();
            $table->integer('account_period')->nullable();
            $table->date('payment_schedule')->nullable();
            $table->decimal('finance_amount')->nullable();
            $table->decimal('freight_charge_usd')->nullable();
            $table->decimal('freight_charge_rmb')->nullable();
            $table->date('freight_payment_date')->nullable();
            $table->decimal('volume')->nullable();
            $table->decimal('insurance_charge')->nullable();
            $table->decimal('tariff')->nullable();
            $table->decimal('reparations_charge')->nullable();
            $table->decimal('commission1')->nullable();
            $table->decimal('commission2')->nullable();
            $table->decimal('commission3')->nullable();
            $table->string('credit_insurance_customers')->nullable();
            $table->decimal('credit_insurance_account_period')->nullable();
            $table->decimal('credit_insurance_limited')->nullable();
            $table->date('bill_of_draft_date')->nullable();
            $table->string('bill_of_draft_bank')->nullable();
            $table->decimal('fob_amount')->nullable();
            $table->date('cc_date')->nullable();
            $table->integer('sale_date')->nullable();
            $table->decimal('gw_for_pl')->nullable();
            $table->decimal('nw_for_pl')->nullable();
            $table->decimal('cm_rate')->nullable();
            $table->string('ship_company')->nullable();
            $table->string('container_number')->nullable();
            $table->string('memo')->nullable();
            $table->string('packinglist_pages')->nullable();
            $table->string('protocol_pages')->nullable();
            $table->string('rma_pages')->nullable();
            $table->string('rma_no')->nullable();
            $table->date('cr_date')->nullable();
            $table->string('bp_pages')->nullable();
            $table->string('bp_no')->nullable();
            $table->decimal('bpcm_cost')->nullable();
            $table->decimal('bpfob_cost')->nullable();
            $table->integer('receive_finished')->default(0)->nullable();

            $table->string('brand_supplier')->default('pvh')->nullable();
            // BOOKING/BC/SHIPPING DOCS/UPLOADING/TRUCK ETA DJIBOUTI/CUT OFF/ETD djibouti/ETA TRANSPORT/ETD TRANSPORT/ETA DES PORT/COMMENT
            $table->date('booking_date')->nullable();
            $table->date('bc_date')->nullable();
            $table->date('shippingdocs_date')->nullable();
            $table->date('uploading_date')->nullable();
            $table->date('truck_eta_djibouti_date')->nullable();
            $table->date('cutoff_date')->nullable();
//            $table->date('etd_djibouti_date')->nullable();
            $table->date('eta_transport_date')->nullable();
            $table->date('etd_transport_date')->nullable();
//            $table->date('eta_des_port_date')->nullable();
            $table->string('forwarder_comment')->nullable();

            $table->timestamps();

            $table->unique('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
}
