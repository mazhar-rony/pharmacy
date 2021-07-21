<?php

namespace App\Http\Controllers\User;

use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        return view('user.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('user.supplier.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'organization' => 'required|unique:suppliers',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $supplier = new Supplier();

        $supplier->name = $request->name;
        $supplier->organization = $request->organization;
        $supplier->slug = str_slug($request->organization);
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;

        $supplier->save();

        Toastr::success('Supplier Successfully Created !' ,'Success');

        return redirect()->route('user.supplier.index');

    }
}
