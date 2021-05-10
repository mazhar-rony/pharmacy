<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{
    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }

    public function accounts()
    {
        return $this->hasMany('App\BankAccount');
    }

    public function loans()
    {
        return $this->hasMany('App\BankLoan');
    }
}
