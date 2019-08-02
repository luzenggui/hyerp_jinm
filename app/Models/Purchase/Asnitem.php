<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;

class Asnitem extends Model
{
    //
    protected $fillable = [
        'asnpackaging_id',
        'poitemroll_id',
        'quantity_shipped',
        'gross_weight',
        'gross_unit',
        'fabric_width',
        'fabric_unit',
        'qa_status',
        'net_weight',
        'net_unit',
        'ucc_number',
        'roll_number',
        'remark',
    ];

    public function poitem() {
        return $this->belongsTo('\App\Models\Purchase\Poitem');
    }

    public function poitemroll() {
        return $this->belongsTo('\App\Models\Purchase\Poitemroll');
    }
}
