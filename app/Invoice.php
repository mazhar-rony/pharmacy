<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function bank_account()
    {
        return $this->belongsTo('App\BankAccount');
    }

    public function invoice_details()
    {
        return $this->hasMany('App\InvoiceDetail');
    }
}
