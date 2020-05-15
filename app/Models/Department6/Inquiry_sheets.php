<?php

namespace App\Models\Department6;

use Illuminate\Database\Eloquent\Model;

class Inquiry_sheets extends Model
{
    //
    protected $fillable = [
        'customername',
        'prod_description',
        'prod_photo',
        'prod_size',
        'customer_item_name',
        'supplier_stock_number',
        'UPC#',
        'prod_qty',
        'FOB_SH_price',
        'ingredients_note',
        'packing_note',
        'remark_factory',
        'process_costs',
        'purchase_costs',
        'total_costs',
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
        ];

    public function purchasedetail() {

        return $this->hasMany('App\Models\Department6\Purchasedetail','inquiry_sheetid');
    }
    public function ingredientdetail() {
        return $this->hasMany('App\Models\Department6\Ingredientdetail','inquiry_sheetid');
    }
    public function processdetail() {
        return $this->hasMany('App\Models\Department6\Processdetail','inquiry_sheetid');
    }
}
