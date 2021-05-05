<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditorPayment extends Model
{
    public function creditor()
    {
        return $this->belongsTo('App\Creditor');
    }
}
