<?php

namespace App\Models\Department6;

use Illuminate\Database\Eloquent\Model;

class Orderprocess extends Model
{
    //
    protected $fillable = [
        'orderid',
        'processid',
        'price',
    ];

    public function process() {
        return $this->hasOne('App\Models\Department6\Process', 'id', 'processid');
    }

    public function order() {
        return $this->hasOne('App\Models\Department6\Order', 'id', 'orderid');
    }
}
