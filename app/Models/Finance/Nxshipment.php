<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Nxshipment extends Model
{
    //
    protected $fillable = [
        'customer_name',
        'invoice_number',
        'contract_number',
        'cyrq',
        'cybd',
        'amount_shipments',
        'amount_hjkp',
        'amount_hjsk',
        'note',
        'amount_kp1',
        'date_kp1',
        'amount_kp2',
        'date_kp2',
        'amount_kp3',
        'date_kp3',
        'amount_kp4',
        'date_kp4',
        'amount_kp5',
        'date_kp5',
        'amount_sk1',
        'date_sk1',
        'amount_sk2',
        'date_sk2',
        'amount_sk3',
        'date_sk3',
        'amount_sk4',
        'date_sk4',
        'amount_sk5',
        'date_sk5',
        'note1',
    ];
}
