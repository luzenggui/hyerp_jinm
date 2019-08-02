<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;

class Poitem extends Model
{
    //
    protected $fillable = [
        'pohead_id',
        'poitemc_id',
        'quantity',
        'quantityreceived',
        'chinesedescrip',
        'unitprice',
        'remark',
    ];

    public function pohead() {
        return $this->belongsTo('App\Models\Purchase\Purchaseorder');
//        return $this->hasOne('App\Models\Purchaseorderc\Poitemc', 'id', 'poitemc_id');
    }

    public function poitemc() {
        return $this->belongsTo('App\Models\Purchaseorderc\Poitemc');
//        return $this->hasOne('App\Models\Purchaseorderc\Poitemc', 'id', 'poitemc_id');
    }

    public function asnpackagings() {
        return $this->hasMany('\App\Models\Purchase\Asnpackaging');
    }

    public function poitemrolls() {
        return $this->hasMany('\App\Models\Purchase\Poitemroll');
    }

    public function asnitems() {
        return $this->hasManyThrough('\App\Models\Purchase\Asnitem', '\App\Models\Purchase\Asnpackaging');
    }

    public function fabric_width() {
        $rtn = 0.0;
        $fabric_width = $this->poitemc->fabric_width;
//        $fabric_width = '56"';        // (61")62/3"
        $pattern1 = '/\((\d+)/';        // 带括号
        $pattern2 = '/(\d+)/';          // 不带括号
        if (preg_match($pattern1, $fabric_width, $match))
            $rtn = $match[1];
        elseif (preg_match($pattern2, $fabric_width, $match))
            $rtn = $match[1];
//        dd($match);
        return $rtn;
    }
}
