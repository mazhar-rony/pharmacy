<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    public function branches()
    {
        return $this->hasMany('App\BankBranch');
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
