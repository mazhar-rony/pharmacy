<?php

namespace App\Http\Controllers\Admin;

use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        return view('admin.supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->route('admin.supplier.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('admin.supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'organization' => 'required|unique:suppliers,id',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $supplier = Supplier::findOrFail($id);

        $supplier->name = $request->name;
        $supplier->organization = $request->organization;
        $supplier->slug = str_slug($request->organization);
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;

        $supplier->save();

        Toastr::success('Supplier Successfully Updated !' ,'Success');

        return redirect()->route('admin.supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        Toastr::success('Supplier Successfully Deleted !' ,'Success');

        return redirect()->back();
    }
}
