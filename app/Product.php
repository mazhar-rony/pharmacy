<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function invoice_details()
    {
        return $this->hasMany('App\InvoiceDetail');
    }

    public function purchase_details()
    {
        return $this->hasMany('App\PurchaseDetail');
    }

    public function return_product_details()
    {
        return $this->hasMany('App\ReturnProductDetail');
    }    
}
