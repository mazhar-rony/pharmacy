<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccountTransaction extends Model
{
    public function account()
    {
        return $this->belongsTo('App\BankAccount');
    }
}
