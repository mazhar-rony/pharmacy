<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }

    public function branch()
    {
        return $this->belongsTo('App\BankBranch');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function account_transactions()
    {
        return $this->hasMany('App\BankAccountTransaction');
    }

    public function invoice()
    {
        return $this->hasOne('App\Invoice');
    }

    public function debtor_payments()
    {
        return $this->hasMany('App\DebtorPayment');
    }

    public function creditor_payments()
    {
        return $this->hasMany('App\CreditorPayment');
    }

    public function bank_loan_transactions()
    {
        return $this->hasMany('App\BankLoanTransaction');
    }
}
