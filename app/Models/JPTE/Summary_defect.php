<?php

namespace App\Models\JPTE;

use Illuminate\Database\Eloquent\Model;

class Summary_defect extends Model
{
    //
    protected $fillable = [
        'defectsheet_id',
        'buyer',
        'washingrepair_qty',
        'washingrepair_rate',
        'sewingrepair_qty',
        'sewingrepair_rate',
        'total_repair',
        'good_pcs'
    ];
}
