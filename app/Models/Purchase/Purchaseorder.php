<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;

class Purchaseorder extends Model
{
    //
    protected $table = 'poheads';

    protected $fillable = [
        'number',
        'descrip',
        'vendor_id',
        'orderdate',
        'submitdate',
        'status',
        'remark',
        'poheadc_id',
    ];

    public function poitems() {
        return $this->hasMany('App\Models\Purchase\Poitem', 'pohead_id', 'id');
    }

    public function vendor() {
        return $this->hasOne('App\Models\Purchase\Vendor', 'id', 'vendor_id');
    }

    public function poheadc() {
        return $this->hasOne('App\Models\Purchaseorderc\Poheadc', 'id', 'poheadc_id');
    }
}
