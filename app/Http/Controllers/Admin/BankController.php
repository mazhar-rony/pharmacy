<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::latest()->get();

        return view('admin.bank.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bank.create');
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
            'name' => 'required|unique:banks',
            'phone' => 'nullable',
            'address' => 'nullable'
        ]);

        $bank = new Bank();

        $bank->name = $request->name;
        $bank->slug = str_slug($request->name);
        $bank->phone = $request->phone;
        $bank->address = $request->address;

        $bank->save();

        Toastr::success('Bank Successfully Created !' ,'Success');

        return redirect()->route('admin.bank.index');
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
        $bank = Bank::findOrFail($id);

        return view('admin.bank.edit', compact('bank'));
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
            'name' => 'required|unique:banks,id',
            'phone' => 'nullable',
            'address' => 'nullable'
        ]);

        $bank = bank::findOrFail($id);

        $bank->name = $request->name;
        $bank->slug = str_slug($request->name);
        $bank->phone = $request->phone;
        $bank->address = $request->address;

        $bank->save();

        Toastr::success('Bank Successfully Updated !' ,'Success');

        return redirect()->route('admin.bank.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);

        $bank->delete();

        Toastr::success('Bank Successfully Deleted !' ,'Success');

        return redirect()->back();
    }
}
