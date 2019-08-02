<?php

namespace App\Models\Purchaseorderc;

use Illuminate\Database\Eloquent\Model;

class Poheadc extends Model
{
    //
    public function poitemcs() {
        return $this->hasMany('App\Models\Purchaseorderc\Poitemc', 'poheadc_id', 'id');
    }

    public function poheads() {
        return $this->hasMany('App\Models\Purchase\Purchaseorder', 'poheadc_id', 'id');
    }

    public function poitems() {
        return $this->hasManyThrough('App\Models\Purchase\Poitem', 'App\Models\Purchase\Purchaseorder', 'poheadc_id', 'pohead_id', 'id');
    }
}
