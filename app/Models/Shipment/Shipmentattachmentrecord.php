<?php

namespace App\Models\Shipment;

use Illuminate\Database\Eloquent\Model;

class Shipmentattachmentrecord extends Model
{
    //
    protected $fillable = [
        'shipment_id',
        'type',
        'filename',
        'path',
        'operation_type',
        'operator',
    ];

    public function shipment() {
        return $this->belongsTo('\App\Models\Shipment\Shipment');
    }
}
