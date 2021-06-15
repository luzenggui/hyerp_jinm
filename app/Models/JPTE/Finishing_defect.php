<?php

namespace App\Models\JPTE;

use Illuminate\Database\Eloquent\Model;

class Finishing_defect extends Model
{
    //
    protected $fillable = [
        'defectsheet_id',
        'finishing_name',
        'finishing_qty',
        'finishing_rate'
    ];
}
