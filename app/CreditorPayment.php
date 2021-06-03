<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditorPayment extends Model
{
    public function creditor()
    {
        return $this->belongsTo('App\Creditor');
    }

    public function bank_account()
    {
        return $this->belongsTo('App\BankAccount');
    }
}
