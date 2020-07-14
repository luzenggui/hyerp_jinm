<?php

namespace App\Models\Department6;

use Illuminate\Database\Eloquent\Model;

class Orderingredient extends Model
{
    //
    protected $fillable = [
        'orderid',
        'ingredientid',
        'qty',
        'price',
        'outprice',
        'total_price',
        'total_outprice',
        'total_qty',
        'ingredient_desc',
        'remark_factory',
    ];

    public function ingredient() {
        return $this->hasOne('App\Models\Department6\Ingredient', 'id', 'ingredientid');
    }

    public function order() {
        return $this->hasOne('App\Models\Department6\Order', 'id', 'orderid');
    }
}
