<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;

class Asnpackaging extends Model
{
    //
    protected $fillable = [
        'asnorder_id',
        'poitem_id',
        'dyelotseries',
        'packaging_code',
        'free_quantity',
    ];

    public function asnitems() {
        return $this->hasMany('\App\Models\Purchase\Asnitem');
    }

    public function asnorder() {
        return $this->belongsTo('\App\Models\Purchase\Asnorder');
    }

    public function poitem() {
        return $this->belongsTo('\App\Models\Purchase\Poitem');
    }
}
