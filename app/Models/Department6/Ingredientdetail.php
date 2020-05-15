<?php

namespace App\Models\Department6;

use Illuminate\Database\Eloquent\Model;

class Ingredientdetail extends Model
{
    //
    protected $fillable = [
            'inquiry_sheetid',
            'ingredientid',
            'qty',
            'price',
            'total_price',
            'total_qty',
        ];

    public function ingredientpart() {
        return $this->hasMany('App\Models\Department6\Ingredient', 'id', 'ingredientid');
    }

    public function inquirysheet() {
        return $this->hasOne('App\Models\Department6\Inquiry_sheets', 'id', 'inquiry_sheetid');
    }
}
