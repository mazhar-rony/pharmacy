<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankLoan extends Model
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

    public function loan_transactions()
    {
        return $this->hasMany('App\BankLoanTransaction');
    }
}
