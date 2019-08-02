<?php

namespace App\Models\Shipment;

use Illuminate\Database\Eloquent\Model;

class Userforwarder extends Model
{
    //
    protected $table = 'user_forwarder';
    protected $fillable = [
        'user_id',
        'forwarder',
    ];

    public function user() {
        return $this->belongsTo('\App\User');
    }
}
