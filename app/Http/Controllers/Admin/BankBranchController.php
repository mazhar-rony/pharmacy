<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\BankBranch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class BankBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = BankBranch::latest()->get();

        return view('admin.bank_branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Bank::orderBy('name')->get();

        return view('admin.bank_branch.create', compact('banks'));
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
            'bank' => 'required',
            'phone' => 'nullable',
            'city' => 'nullable',
            'location' => 'nullable',
            'address' => 'nullable'
        ]);

        $branch = new BankBranch();

        $branch->name = $request->name;
        $branch->slug = str_slug($request->name);
        $branch->bank_id = Bank::find($request->bank)->id;
        $branch->phone = $request->phone;
        $branch->city = $request->city;
        $branch->location = $request->location;
        $branch->address = $request->address;
        
        $branch->save();
       
        Toastr::success('Branch Successfully Created !' ,'Success');

        return redirect()->route('admin.branch.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $branch = BankBranch::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = BankBranch::findOrFail($id);
        $banks = Bank::orderBy('name')->get();

        return view('admin.bank_branch.edit', compact('branch', 'banks'));
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
            'bank' => 'required',
            'phone' => 'nullable',
            'city' => 'nullable',
            'location' => 'nullable',
            'address' => 'nullable'
        ]);

        $branch = BankBranch::findOrFail($id);

        $branch->name = $request->name;
        $branch->slug = str_slug($request->name);
        $branch->bank_id = Bank::find($request->bank)->id;
        $branch->phone = $request->phone;
        $branch->city = $request->city;
        $branch->location = $request->location;
        $branch->address = $request->address;
        
        $branch->save();
       
        Toastr::success('Branch Successfully Updated !' ,'Success');

        return redirect()->route('admin.branch.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = BankBranch::findOrFail($id);

        $branch->delete();

        Toastr::success('Branch Successfully Deleted !' ,'Success');

        return redirect()->back();
    }
}
