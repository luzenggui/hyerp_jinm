<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    //
    protected $fillable = [
        'number',
        'name',
        'contact_name1',
        'contact_phone1',
        'contact_name2',
        'contact_phone2',
        'address1',
        'address2',
    ];
}
