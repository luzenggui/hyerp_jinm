<?php

namespace App\Models\Department6;

use Illuminate\Database\Eloquent\Model;

class Processdetail extends Model
{
    //
    protected $fillable = [
        'inquiry_sheetid',
        'processid',
        'price',
        ];

    public function process() {
        return $this->hasMany('App\Models\Department6\Process', 'id', 'processid');
    }

    public function inquirysheet() {
        return $this->hasOne('App\Models\Department6\Inquiry_sheets', 'id', 'inquiry_sheetid');
    }
}
