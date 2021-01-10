<?php

namespace App\Models\Vouch;

use Illuminate\Database\Eloquent\Model;

class Inventoryacc extends Model
{
    //
    protected $fillable=[
        'mtid',
        'qty',
        'sheetno',
        'type',
    ];

    protected function materialcode(){
        return $this->hasOne('\App\Models\Vouch\Material','id','mtid');
    }
}
