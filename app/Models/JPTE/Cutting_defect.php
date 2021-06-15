<?php

namespace App\Models\JPTE;

use Illuminate\Database\Eloquent\Model;

class Cutting_defect extends Model
{
    //
    protected $fillable = [
        'defectsheet_id',
        'cutting_name',
        'cutting_qty',
        'defect_qty',
        'cutting_defectsrate',
        'cutting_note'
    ];
}
