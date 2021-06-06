<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnProduct extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function return_product_details()
    {
        return $this->hasMany('App\ReturnProductDetail');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice',);
    }
}
