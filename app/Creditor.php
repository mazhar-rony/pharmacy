<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creditor extends Model
{
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function creditor_payments()
    {
        return $this->hasMany('App\CreditorPayment');
    }
}
