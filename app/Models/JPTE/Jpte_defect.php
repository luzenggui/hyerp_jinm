<?php

namespace App\Models\JPTE;

use Illuminate\Database\Eloquent\Model;

class Jpte_defect extends Model
{
    //
    protected $fillable = [
        'defectsheet_id',
        'lineno',
        'supervisor',
        'customer',
        'styleno',
        'sewing_start_date',
        'check_qty',
        'pass_inspection_output',
        'broken_stitch',
        'skip_stitch',
        'uneven',
        'uncut_threads',
        'damage',
        'unparallel_joint',
        'puckering',
        'wrong_label',
        'dirt_oil_stain',
        'raw_edge',
        'colour_shading',
        'wrong_size',
        'side_seam',
        'holes',
        'off_shape',
        'uneven_guage',
        'misposition_buttons',
        'box_slant',
        'uneven_heat_seal',
        'open_seam',
        'hilow',
        'others',
        'others1',
        'others2',
        'others3',
        'others4',
        'others5',
        'total_defects',
        'defetsrate',
        'finishing_return',
        'finishing_returnrate'
    ];
}
