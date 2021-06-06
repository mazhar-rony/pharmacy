<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creditor extends Model
{
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function creditor_payments()
    {
        return $this->hasMany('App\CreditorPayment');
    }

    public function purchase()
    {
        return $this->hasOne('App\Purchase');
    }
}
