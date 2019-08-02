<?php

namespace App\Models\Shipment;

use Illuminate\Database\Eloquent\Model;

class Shipmentattachment extends Model
{
    //
    protected $fillable = [
        'shipment_id',
        'type',
        'filename',
        'path',
    ];
}
