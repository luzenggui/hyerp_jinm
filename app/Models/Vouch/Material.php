<?php

namespace App\Models\Vouch;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //
    protected $fillable=[
        'code',
        'en_name',
        'ch_name',
        'memo',
    ];
}
