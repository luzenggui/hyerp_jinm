<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;

class Uservendor extends Model
{
    //
    protected $fillable = [
        'user_id',
        'vendor_id',
    ];

    public function user() {
        return $this->belongsTo('\App\User');
    }

    public function vendor() {
        return $this->belongsTo('\App\Models\Purchase\Vendor');
    }
}
