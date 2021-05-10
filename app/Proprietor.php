<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proprietor extends Model
{
    public function proprietor_transactions()
    {
        return $this->hasMany('App\ProprietorTransaction');
    }
}
