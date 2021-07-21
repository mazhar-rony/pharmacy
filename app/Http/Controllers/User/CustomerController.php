<?php

namespace App\Http\Controllers\User;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        
        return view('user.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('user.customer.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'organization' => 'required|unique:customers',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $customer = new Customer();

        $customer->name = $request->name;
        $customer->organization = $request->organization;
        $customer->phone = $request->phone;
        $customer->address = $request->address;

        $customer->save();

        Toastr::success('Customer Successfully Created !' ,'Success');

        return redirect()->route('user.customer.index');
    }
}
