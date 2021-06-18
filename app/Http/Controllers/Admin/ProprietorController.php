<?php

namespace App\Http\Controllers\Admin;

use App\Cash;
use Carbon\Carbon;
use App\Proprietor;
use Illuminate\Http\Request;
use App\ProprietorTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class ProprietorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proprietors = Proprietor::latest()->get();

        return view('admin.proprietor.index', compact('proprietors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.proprietor.create');
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
            'designation' => 'required',
            'phone' => 'required'
        ]);

        $proprietor = new Proprietor();

        $proprietor->name = $request->name;
        $proprietor->designation = $request->designation;
        $proprietor->phone = $request->phone;

        $proprietor->save();

        Toastr::success('Proprietor Successfully Created !' ,'Success');

        return redirect()->route('admin.proprietor.index');
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
        $proprietor = Proprietor::find($id);

        return view('admin.proprietor.edit', compact('proprietor'));
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
            'designation' => 'required',
            'phone' => 'required'
        ]);

        $proprietor = Proprietor::find($id);

        $proprietor->name = $request->name;
        $proprietor->designation = $request->designation;
        $proprietor->phone = $request->phone;
        
        $proprietor->save();

        Toastr::success('Proprietor Successfully Updated !' ,'Success');

        return redirect()->route('admin.proprietor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proprietor = Proprietor::find($id);

        $proprietor->delete();

        Toastr::success('Proprietor Successfully Deleted !' ,'Success');

        return redirect()->back();
    }

    public function transaction($id)
    {
        $proprietor = Proprietor::find($id);

        $income = DB::table('cashes')->sum('income');
        $expense = DB::table('cashes')->sum('expense');
        $cash = $income - $expense;

        return view('admin.proprietor.transaction', compact('proprietor', 'cash'));
    }

    public function deposite(Request $request, $id)
    {   
        $this->validate($request,[
            'deposite' => 'required',
            'deposite_date' => 'required|date'
        ]);

        $proprietor = Proprietor::find($id);
        $transaction = new ProprietorTransaction();
        $cash = new Cash();

        // Used Carbon Instead doing manually format date
        /*$date = strtotime($request->deposite_date);
        $transaction->transaction_date = date('Y-m-d', $date);*/

        try{
            DB::transaction(function () use($request, $proprietor, $transaction, $cash){

                $transaction->proprietor_id = $proprietor->id;
                $transaction->deposite = $request->deposite;
                $transaction->transaction_date = Carbon::parse($request->deposite_date)->format('Y-m-d');
                $transaction->description = 'Proprietor ' . $proprietor->name . ' Deposited to Cash';
                $transaction->save();

                $cash->date = $transaction->transaction_date;
                $cash->income = $transaction->deposite;
                $cash->description = 'Proprietor ' . $proprietor->name . ' Deposited to Cash';
                $cash->save();
            }, 3);

        }catch(\Exception $ex){

            Toastr::error('Something went wrong ! Try again...' ,'Error');
            //Toastr::error($ex->getMessage() ,'Error');

            return redirect()->back();
        }

        Toastr::success('Successfully Deposited !' ,'Success');

        return redirect()->route('admin.proprietor.index');

    }

    public function withdraw(Request $request, $id)
    {
        $this->validate($request,[
            'withdraw' => 'required',
            'withdraw_date' => 'required|date',
            'description' => 'required'
        ]);

        $proprietor = Proprietor::find($id);
        $transaction = new ProprietorTransaction();
        $cash = new Cash();
        
        // Used Carbon Instead doing manually format date
        /*$date = strtotime($request->withdraw_date);
        $transaction->transaction_date = date('Y-m-d', $date);*/

        try{
            DB::transaction(function () use($request, $proprietor, $transaction, $cash){

                $transaction->proprietor_id = $proprietor->id;
                $transaction->withdraw = $request->withdraw;
                $transaction->transaction_date = Carbon::parse($request->withdraw_date)->format('Y-m-d');
                $transaction->description = 'Proprietor ' . $proprietor->name . ' Withdrawn from Cash for: '.$request->description;
                $transaction->save();

                $cash->date = $transaction->transaction_date;
                $cash->expense = $transaction->withdraw;
                $cash->description = 'Proprietor ' . $proprietor->name . ' Withdrawn from Cash for: '.$request->description;
                $cash->save();
            }, 3);

        }catch(\Exception $ex){

            Toastr::error('Something went wrong ! Try again...' ,'Error');
            //Toastr::error($ex->getMessage() ,'Error');

            return redirect()->back();
        }

        Toastr::success('Successfully Withdrawn !' ,'Success');

        return redirect()->route('admin.proprietor.index');
    }
}
