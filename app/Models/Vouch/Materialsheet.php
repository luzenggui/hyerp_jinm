<?php

namespace App\Models\Vouch;

use Illuminate\Database\Eloquent\Model;

class Materialsheet extends Model
{
    //
    protected $fillable=[
        'sheetno',
        'invoiceno',
        'type',
        'mtid',
        'qty',
        'unitprice',
        'amount',
    ];

    protected function materialcode(){
        return $this->hasOne('\App\Models\Vouch\Material','id','mtid');
    }
}
