<?php

namespace App\Models\Shipment;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    //
    protected $fillable = [
        'dept',
        'customer_name',
        'customer_address',
        'invoice_number',
        'oversea_fty_ci_no',
        'contract_number',
        'type',
        'purchaseorder_number',
        'buyer_po_no',
        'cargo_description',
        'hs_code',
        'processing_plant',
        'trade_type',
        'dest_country',
        'dest_port',
        'incoterm',
        'ship_by',
        'crd',
        'dcd_date',
        'shipment_no',
        'forwarder',
        'etd',
        'eta',
        'deliver_no',
        'arrived_wh_date',
        'customs_no',
        'customs_declaration_no',
        'customs_declaration_return',
        'bill_no',
        'issue_blank',
        'issue_blank_address',
        'issue_blank_swift',
        'negotiation_ci_date',
        'negotiation_date',
        'tradecard_login_date',
        'tradecard_confirmation_date',
        'payment_by',
        'qty_for_customs',
        'amount_for_customs',
        'qty_for_customer',
        'amount_for_customer',
        'amount_customer_payment',
        'customer_payment_date',
        'different_column_ao_vs_am',
        'percent_different_column_ao_vs_am',
        'first_sale',
        'wuxi_obtain_amount',
        'pmj_obtain_amount',
        'account_period',
        'payment_schedule',
        'finance_amount',
        'freight_charge_usd',
        'freight_charge_rmb',
        'volume',
        'insurance_charge',
        'tariff',
        'reparations_charge',
        'commission1',
        'commission2',
        'commission3',
        'credit_insurance_customers',
        'credit_insurance_account_period',
        'credit_insurance_limited',
        'bill_of_draft_date',
        'bill_of_draft_blank',
        'fob_amount',
        'cc_date',
        'sale_date',
        'gw_for_pl',
        'nw_for_pl',
        'cm_rate',
        'ship_company',
        'container_number',
        'memo',

        'brand_supplier',
        'booking_date',
        'bc_date',
        'shippingdocs_date',
        'uploading_date',
        'truck_eta_djibouti_date',
        'cutoff_date',
//        'etd_djibouti_date',
        'eta_transport_date',
        'etd_transport_date',
//        'eta_des_port_date',
        'forwarder_comment',
    ];

    public function shipmentitems() {
        return $this->hasMany('\App\Models\Shipment\Shipmentitem');
    }

    public function shipmentattachments() {
        return $this->hasMany('\App\Models\Shipment\Shipmentattachment');
    }
}
