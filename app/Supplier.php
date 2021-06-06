<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function creditor()
    {
        return $this->hasOne('App\Creditor');
    }

    public function purchase()
    {
        return $this->hasOne('App\Purchase');
    }
}
