<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Cash;
use Carbon\Carbon;
use App\BankBranch;
use App\BankAccount;
use Illuminate\Http\Request;
use App\BankAccountTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$accounts = BankAccount::latest()->where('user_id', Auth::id())->get();
        $accounts = BankAccount::latest()->get();

        return view('admin.bank_account.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Bank::orderBy('name')->get();

        return view('admin.bank_account.create', compact('banks'));
    }

    public function getBranches(Request $request)
    {
        if($request->has('bank'))
        {
            return Bank::find($request->bank)->branches()->get();
            //return \DB::table('bank_branches')->where('bank_id', $request->bank)->get();
        }
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
            'account_name' => 'required',
            //validate combined uniqueness
            'account_number' => 'required|unique:bank_accounts,account_number,NULL,id,bank_id,' . $request->bank,
            'bank' => 'required|integer',
            'branch' => 'required|integer', 
            'type' => 'required|integer|between:0,1',
            'balance' => 'required|numeric',           
        ]);
        
        $account = new BankAccount();

        $account->user_id = Auth::user()->id;
        $account->account_name = $request->account_name;
        $account->account_number = $request->account_number;
        $account->bank_id = $request->bank;
        $account->branch_id = $request->branch;
        $account->balance = $request->balance;

        if($request->type == 0)
        {
            $account->account_type = 'Current';
        }
        else if($request->type == 1)
        {
            $account->account_type = 'Savings';
        }
        
        $account->save();

        Toastr::success('Account Successfully Created !' ,'Success');

        return redirect()->route('admin.account.index');
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
        $account = BankAccount::find($id);
        
        $banks = Bank::orderBy('name')->get();
        $branches = \DB::table('bank_branches')->where('bank_id', $account->bank->id)->get();

        return view('admin.bank_account.edit', compact('account', 'banks', 'branches'));
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
            'account_name' => 'required',
            //validate combined uniqueness
            'account_number' => 'required|unique:bank_accounts,account_number,'.BankAccount::find($id)->id.',id,bank_id,' . $request->bank,
            'bank' => 'required|integer',
            'branch' => 'required|integer', 
            'type' => 'required|integer|between:0,1',
            'balance' => 'required|numeric',  
        ]);

        $account = BankAccount::find($id);

        $account->user_id = Auth::user()->id;
        $account->account_name = $request->account_name;
        $account->account_number = $request->account_number;
        $account->bank_id = Bank::find($request->bank)->id;
        $account->branch_id = BankBranch::find($request->branch)->id;
        $account->balance = $request->balance;

        if($request->type == 0)
        {
            $account->account_type = 'Current';
        }
        else if($request->type == 1)
        {
            $account->account_type = 'Savings';
        }
        
        $account->save();

        Toastr::success('Account Successfully Updated !' ,'Success');

        return redirect()->route('admin.account.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = BankAccount::find($id);

        $account->delete();

        Toastr::success('Account Successfully Deleted !' ,'Success');

        return redirect()->back();
    }

    public function transaction($id)
    {
        $account = BankAccount::find($id);

        $income = DB::table('cashes')->sum('income');
        $expense = DB::table('cashes')->sum('expense');
        $cash = $income - $expense;

        return view('admin.bank_account.transaction', compact('account', 'cash'));
    }

    public function deposite(Request $request, $id)
    {   
        $this->validate($request,[
            'deposite' => 'required',
            'deposited_from' => 'required',
            'deposite_date' => 'required|date'
        ]);

        $account = BankAccount::find($id);
        $transaction = new BankAccountTransaction();
        $cash = new Cash();

        // Used Carbon Instead doing manually format date
        /*$date = strtotime($request->deposite_date);
        $transaction->transaction_date = date('Y-m-d', $date);*/

        try{
            DB::transaction(function () use($request, $account, $transaction, $cash){
                $account->balance += $request->deposite;
                $account->save();

                $transaction->bank_account_id = $account->id;
                $transaction->deposite = $request->deposite;
                $transaction->transaction_date = Carbon::parse($request->deposite_date)->format('Y-m-d');
                $transaction->balance = $account->balance;
                $transaction->save();

                if($request->deposited_from === 'cash')
                {
                    $cash->date = $transaction->transaction_date;
                    $cash->expense = $transaction->deposite;
                    $cash->description = 'Deposited Money To Account Number: ' . $account->account_number .' Of ' . $account->bank->name . ' - ' . $account->branch->name . ' From Cash';
                    $cash->save();
                }
            }, 3);

        }catch(\Exception $ex){

            Toastr::error('Something went wrong ! Try again...' ,'Error');
            //Toastr::error($ex->getMessage() ,'Error');

            return redirect()->back();
        }

        Toastr::success('Successfully Deposited !' ,'Success');

        return redirect()->route('admin.account.index');

    }

    public function withdraw(Request $request, $id)
    {
        $this->validate($request,[
            'withdraw' => 'required',
            'deposited_to' => 'required',
            'withdraw_date' => 'required|date'
        ]);

        $account = BankAccount::find($id);
        $transaction = new BankAccountTransaction();
        $cash = new Cash();
        
        // Used Carbon Instead doing manually format date
        /*$date = strtotime($request->withdraw_date);
        $transaction->transaction_date = date('Y-m-d', $date);*/

        if($request->withdraw <= $account->balance)
        {
            try{
                DB::transaction(function () use($request, $account, $transaction, $cash){
                    
                    $account->balance -= $request->withdraw;
                    $account->save();
    
                    $transaction->bank_account_id = $account->id;
                    $transaction->withdraw = $request->withdraw;
                    $transaction->transaction_date = Carbon::parse($request->withdraw_date)->format('Y-m-d');
                    $transaction->description = $request->description;
                    $transaction->balance = $account->balance;
                    $transaction->save();
    
                    if($request->deposited_to === 'cash')
                    {
                        $cash->date = $transaction->transaction_date;
                        $cash->income = $transaction->withdraw;
                        $cash->description = 'Withdrawn Money From Account Number: ' . $account->account_number .' Of ' . $account->bank->name . ' - ' . $account->branch->name . ' To Cash';
                        $cash->save();
                    }
                }, 3);
    
            }catch(\Exception $ex){
    
                Toastr::error('Something went wrong ! Try again...' ,'Error');
                //Toastr::error($ex->getMessage() ,'Error');
    
                return redirect()->back();
            }
        }
        else
        {
            Toastr::error('Insufficient Balance to Withdraw !' ,'Error');
            
            return redirect()->back();
        }
        

        Toastr::success('Successfully Withdrawn !' ,'Success');

        return redirect()->route('admin.account.index');
    }

    public function interest(Request $request, $id)
    {
        $this->validate($request,[
            'interest' => 'required',
            'interest_date' => 'required|date'
        ]);

        $account = BankAccount::find($id);
        $transaction = new BankAccountTransaction();

        // Used Carbon Instead doing manually format date
        /*$date = strtotime($request->interest_date);
        $transaction->transaction_date = date('Y-m-d', $date);*/

        try{
            DB::transaction(function () use($request, $account, $transaction){
                $account->balance += $request->interest;
                $account->save();

                $transaction->bank_account_id = $account->id;
                $transaction->interest = $request->interest;
                $transaction->transaction_date = Carbon::parse($request->interest_date)->format('Y-m-d');
                $transaction->balance = $account->balance;
                $transaction->save();
            }, 3);

        }catch(\Exception $ex){

            Toastr::error('Something went wrong ! Try again...' ,'Error');
            //Toastr::error($ex->getMessage() ,'Error');

            return redirect()->back();
        }

        Toastr::success('Interest Successfully Deposited !' ,'Success');

        return redirect()->route('admin.account.index');
    }
}
