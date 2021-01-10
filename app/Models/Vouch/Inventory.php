<?php

namespace App\Models\Vouch;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    protected $fillable=[
        'mtid',
        'qty',
    ];

    protected function materialcode(){
        return $this->hasOne('\App\Models\Vouch\Material','id','mtid');
    }
}
