<?php

namespace App\Models\Department6;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'customername',
        'prod_description',
        'prod_photo',
        'prod_size',
        'customer_item_name',
        'supplier_stock_number',
        'UPC',
        'prod_qty',
        'FOB_SH_price',
        'ingredients_note',
        'packing_note',
        'remark_factory',
        'process_costs',
        'process_taxcosts',
        'purchase_costs',
        'purchase_outcosts',
        'total_costs',
        'total_outcosts',
        'remark',
        'length_carton',
        'width_carton',
        'high_carton',
        'qty_percarton',
        'vol_total',
        'qty_container',
        'inland_freight',
        'arlington_ocean_freight',
        'atc_ocean_freight',
        'risk_rate',
        'fob_shanghai',
        'import_rate',
        'arlington_ldp',
        'atc_ldp',
        'process_tax',
        'exchange_rate',
    ];

    public function orderpart() {

        return $this->hasMany('App\Models\Department6\Orderpart','orderid');
    }
    public function orderingredient() {
        return $this->hasMany('App\Models\Department6\Orderingredient','orderid');
    }
    public function orderprocess() {
        return $this->hasMany('App\Models\Department6\Orderprocess','orderid');
    }
}
