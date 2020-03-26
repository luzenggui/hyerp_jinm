<?php

namespace App\Models\Personal;

use Illuminate\Database\Eloquent\Model;

class CheckRecord extends Model
{
    //
    protected $table = 'checkrecords';

    protected $fillable = [
        'inputdate',
        'name',
        'telno',
        'department',
        'address',
        'temperature',
        'stuation_self',
        'stuation_family',
        'contactname_merg',
        'contacttelno_merg',
        'other_note',
        'creator',
        ];
}
