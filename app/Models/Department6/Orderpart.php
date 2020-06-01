<?php

namespace App\Models\Department6;

use Illuminate\Database\Eloquent\Model;

class Orderpart extends Model
{
    //
    protected $fillable = [
        'orderid',
        'partid',
        'fabric_desc',
        'composition',
        'valid_width',
        'edge_to_edge_width',
        'qty',
        'price',
        'total_qty',
        'total_price',
        'factoryname'
    ];

    public function part() {
        return $this->hasOne('App\Models\Department6\Part', 'id', 'partid');
    }

    public function order() {
        return $this->hasOne('App\Models\Department6\Order', 'id', 'orderid');
    }
}
