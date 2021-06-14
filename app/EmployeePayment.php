<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeePayment extends Model
{
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function bank_account()
    {
        return $this->belongsTo('App\BankAccount');
    }
}
