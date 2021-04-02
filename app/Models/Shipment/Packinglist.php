<?php

namespace App\Models\Shipment;

use Illuminate\Database\Eloquent\Model;

class Packinglist extends Model
{
    //
    protected $fillable = [
        'fph',
        'hth',
        'po',
        'dpci',
        'proname',
        'total_quantity',
        'length',
        'width',
        'height',
        'jx',
        'quantity_box',
        'volume',
        'gross_weight',
        'gross_weight_perbox',
        'net_weight',
        'net_weight_prebox',
        'factoryname',
        'boxspec',
        'boxno',
        'date_vanning'
    ];
}
