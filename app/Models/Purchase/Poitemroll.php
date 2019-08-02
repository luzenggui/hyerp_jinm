<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;

class Poitemroll extends Model
{
    //
    protected $fillable = [
        'poitem_id',
        'roll_number',
        'quantity_shipped',
        'gross_weight',
        'gross_unit',
        'fabric_width',
        'fabric_unit',
        'qa_status',
        'net_weight',
        'net_unit',
        'ucc_number',
        'remark',
        'remark2',
        'remark3',
        'dyelotseries',
    ];
}
