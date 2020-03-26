<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Shipmentinfo extends Model
{
    //
    protected $fillable = [
        'department',
        'custname',
        'invoiceno',
        'pono',
        'qty_bg',
        'amount_bg',
        'qty_yf',
        'amount_yf',
    ];
}
