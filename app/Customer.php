<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function creditor()
    {
        return $this->hasOne('App\Creditor');
    }
}
