<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function bank_account()
    {
        return $this->belongsTo('App\BankAccount');
    }

    public function purchase_details()
    {
        return $this->hasMany('App\PurchaseDetail');
    }

    public function creditor()
    {
        return $this->belongsTo('App\Creditor');
    }
}
