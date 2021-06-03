<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function creditor()
    {
        return $this->hasOne('App\Creditor');
    }

    public function debtor()
    {
        return $this->hasOne('App\Debtor');
    }

    public function invoice()
    {
        return $this->hasOne('App\Invoice');
    }
}
