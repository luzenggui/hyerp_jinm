<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Packinfo extends Model
{
    //
    protected $fillable = [
        'pono',
        'qty',
        'amount',
    ];
}
