<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $fillable = [
        'invno',
        'departno',
        'customer',
        'invdate',
        'maker',
        'productname',
        'pono',
        'factory',
        'destination',
        'shipdate',
        'verification_no',
        'shipcompany',
        'shipno',
        'paymethod',
        'quantity',
        'payamount_jintex',
        'payamount_wuxi',
        'fore_paydate',
        'paydate',
        'freight',
        'remark',
    ];
}
