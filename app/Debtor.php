<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debtor extends Model
{
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function debtor_payments()
    {
        return $this->hasMany('App\DebtorPayment');
    }
}
