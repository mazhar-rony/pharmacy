<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProprietorTransaction extends Model
{
    public function proprietor()
    {
        return $this->belongsTo('App\Proprietor');
    }
}
