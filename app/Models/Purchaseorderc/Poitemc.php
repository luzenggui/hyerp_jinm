<?php

namespace App\Models\Purchaseorderc;

use Illuminate\Database\Eloquent\Model;

class Poitemc extends Model
{
    //
    public function poheadc() {
        return $this->hasOne('\App\Models\Purchaseorderc\Poheadc', 'id', 'poheadc_id');
    }

    public function poitems() {
        return $this->hasMany('App\Models\Purchase\Poitem', 'poitemc_id', 'id');
    }
}
