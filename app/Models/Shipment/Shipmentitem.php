<?php

namespace App\Models\Shipment;

use Illuminate\Database\Eloquent\Model;

class Shipmentitem extends Model
{
    //
    protected $fillable = [
        'shipment_id',
        'contract_number',
        'purchaseorder_number',
        'qty_for_customer',
        'amount_for_customer',
        'volume',
    ];
}
