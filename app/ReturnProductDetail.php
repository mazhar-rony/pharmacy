<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnProductDetail extends Model
{
    public function return_product()
    {
        return $this->belongsTo('App\ReturnProduct');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
