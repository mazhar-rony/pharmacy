<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function debtor()
    {
        return $this->hasOne('App\Debtor');
    }

    public function invoice()
    {
        return $this->hasOne('App\Invoice');
    }

    public function return_product()
    {
        return $this->hasOne('App\ReturnProduct');
    }
}
