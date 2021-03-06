<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankLoanTransaction extends Model
{
    public function loan()
    {
        return $this->belongsTo('App\BankLoan');
    }

    public function bank_account()
    {
        return $this->belongsTo('App\BankAccount');
    }
}
