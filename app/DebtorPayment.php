<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebtorPayment extends Model
{
    public function debtor()
    {
        return $this->belongsTo('App\Debtor');
    }

    public function bank_account()
    {
        return $this->belongsTo('App\BankAccount');
    }
}
