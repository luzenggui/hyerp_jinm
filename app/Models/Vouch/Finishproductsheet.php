<?php

namespace App\Models\Vouch;

use Illuminate\Database\Eloquent\Model;

class Finishproductsheet extends Model
{
    //
    protected $fillable=[
        'invoiceno',
        'sheetno',
        'type',
        'fgid',
        'patt',
        'color',
        'qty',
        'unitprice',
        'amount',
        'cmunitprice',
        'cmamount',
    ];

    protected function finishproductcode(){
        return $this->hasOne('\App\Models\Vouch\Finishproduct','id','fgid');
    }
}
