<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;

class Asnshipment extends Model
{
    //
    protected $fillable = [
        'asn_id',
        'gross_weight',
        'gross_unit',
        'transportation_type_code',
        'ref_bm_identification',
        'ref_va_identification',
        'ship_mode',
        'ship_date',
        'delivery_date',
        'estimated_arrival_date',
        'shipper_name',
        'country_of_origin',
        'country_of_destination',
    ];

    public function asnorders() {
        return $this->hasMany('\App\Models\Purchase\Asnorder');
    }
}
