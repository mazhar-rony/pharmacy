<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function employee_payments()
    {
        return $this->hasMany('App\EmployeePayment');
    }
}
