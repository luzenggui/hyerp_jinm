<?php

namespace App\Models\Development;

use Illuminate\Database\Eloquent\Model;

class Fabricdischarge extends Model
{
    //
    protected $fillable = [
        'department',
        'contactor',
        'contactor_tel',
        'style',
        'version',
        'applydate',
        'status',
        'style_des',
        'fabric_specification',
        'weight',
        'width',
        'lattice_cycle',
        'requirement',
        'fabric_shrikage_grain',
        'fabric_shrikage_zonal',
        'quantity',
        'size_allotment',
        'XXS',
        'XS',
        'S',
        'M',
        'L',
        'XL',
        'XXL',
        'XXXL',
        'note',
        'flag1',
        'flag2',
        'num1',
        'num2',
        'createname',
    ];

    public function getnumber($id) {
        $query= Fabricdischarge::where("id","<","$id");
        $query->where("flag2","=","0");
        return $query->count("*");
    }
}
