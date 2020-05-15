<?php

namespace App\Models\Department6;

use Illuminate\Database\Eloquent\Model;

class Purchasedetail extends Model
{
    //
    protected $fillable = [
        'inquiry_sheetid',
        'partid',
        'fabrics_desc',
        'composition',
        'valid_width',
        'edge_to_edge_width',
        'qty',
        'price',
        'total_qty',
        'total_price',
        'factoryname'
    ];

    public function part() {
        return $this->hasMany('App\Models\Department6\Part', 'id', 'partid');
    }

    public function inquirysheet() {
        return $this->hasOne('App\Models\Department6\Inquiry_sheets', 'id', 'inquiry_sheetid');
    }
}
