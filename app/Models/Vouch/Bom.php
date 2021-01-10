<?php

namespace App\Models\Vouch;

use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    //
    protected $fillable=[
        'fgid',
        'mtid',
        'qty',
    ];

    protected function materialcode(){
        return $this->hasOne('\App\Models\Vouch\Material','id','mtid');
    }

    protected function finishproductcode(){
        return $this->hasOne('\App\Models\Vouch\Finishproduct','id','fgid');
    }

}
