<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;

class Asn extends Model
{
    //
    protected $fillable = [
        'interchange_datetime',
        'interchange_control_number',
        'test_indicator',
        'data_interchange_datetime',
        'transaction_set_control_no',
        'asn_number',
    ];

    public function asnshipments() {
        return $this->hasMany('\App\Models\Purchase\Asnshipment');
    }

}
