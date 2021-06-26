<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Cash;
use App\BankLoan;
use Carbon\Carbon;
use App\BankBranch;
use App\BankAccount;
use App\BankLoanTransaction;
use Illuminate\Http\Request;
use App\BankAccountTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BankLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = BankLoan::latest()->where('is_paid', 0)->get();

        return view('admin.bank_loan.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Bank::orderBy('name')->get();

        return view('admin.bank_loan.create', compact('banks'));
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
            'account_number' => 'required|unique:bank_loans,account_number,NULL,id,bank_id,' . $request->bank,
            'bank' => 'required|integer',
            'branch' => 'required|integer', 
            'type' => 'required|integer|between:0,1',
            'loan_amount' => 'required|numeric',
            'emi_amount' => 'required|numeric', 
            'total_emi_no' => 'required|integer',
            'loan_date' => 'required|date'         
        ]);
        
        $loanAccount = new BankLoan();

        $loanAccount->user_id = Auth::user()->id;
        $loanAccount->account_name = $request->account_name;
        $loanAccount->account_number = $request->account_number;
        $loanAccount->bank_id = $request->bank;
        $loanAccount->branch_id = $request->branch;
        $loanAccount->loan_amount = $request->loan_amount;
        $loanAccount->emi_amount = $request->emi_amount;
        $loanAccount->total_emi = $request->total_emi_no;
        $loanAccount->loan_date = Carbon::parse($request->loan_date)->format('Y-m-d');

        if($request->type == 0)
        {
            $loanAccount->account_type = 'Current';
        }
        else if($request->type == 1)
        {
            $loanAccount->account_type = 'Savings';
        }
        
        $loanAccount->save();

        Toastr::success('Loan Account Successfully Created !' ,'Success');

        return redirect()->route('admin.loan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = BankLoan::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = BankLoan::findOrFail($id);
        
        $banks = Bank::orderBy('name')->get();
        $branches = \DB::table('bank_branches')->where('bank_id', $account->bank->id)->get();

        return view('admin.bank_loan.edit', compact('account', 'banks', 'branches'));
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
            'account_number' => 'required|unique:bank_loans,account_number,NULL,id,bank_id,' . $request->bank,
            'bank' => 'required|integer',
            'branch' => 'required|integer', 
            'type' => 'required|integer|between:0,1',
            'loan_amount' => 'required|numeric',
            'emi_amount' => 'required|numeric', 
            'total_emi_no' => 'required|integer',
            'loan_date' => 'required|date'         
        ]);
        
        $loanAccount = BankLoan::findOrFail($id);

        $loanAccount->user_id = Auth::user()->id;
        $loanAccount->account_name = $request->account_name;
        $loanAccount->account_number = $request->account_number;
        $loanAccount->bank_id = Bank::find($request->bank)->id;
        $loanAccount->branch_id = BankBranch::find($request->branch)->id;
        $loanAccount->loan_amount = $request->loan_amount;
        $loanAccount->emi_amount = $request->emi_amount;
        $loanAccount->total_emi = $request->total_emi_no;
        $loanAccount->loan_date = Carbon::parse($request->loan_date)->format('Y-m-d');

        if($request->type == 0)
        {
            $loanAccount->account_type = 'Current';
        }
        else if($request->type == 1)
        {
            $loanAccount->account_type = 'Savings';
        }
        
        $loanAccount->save();

        Toastr::success('Loan Account Successfully Updated !' ,'Success');

        return redirect()->route('admin.loan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = BankLoan::findOrFail($id);

        $account->delete();

        Toastr::success('Loan Account Successfully Deleted !' ,'Success');

        return redirect()->back();
    }

    public function transaction($id)
    {
        $account = BankLoan::findOrFail($id);

        $banks = Bank::orderBy('name')->get();

        $income = DB::table('cashes')->sum('income');
        $expense = DB::table('cashes')->sum('expense');
        $cash = $income - $expense;
        
        return view('admin.bank_loan.transaction', compact('account', 'banks', 'cash'));
    }

    public function payEMI(Request $request, $id)
    {
        $this->validate($request,[
            'emi_no' => 'required|integer',
            'emi' => 'required|numeric',            
            'bank' => 'required_if:payment_type,==,cheque|integer',
            'account' => 'required_if:payment_type,==,cheque|integer', 
            'payment_type' => 'required',            
            'emi_date' => 'required|date'         
        ]);
        
        $loanAccount = BankLoan::findOrFail($id);
        $loanTransaction = new BankLoanTransaction();
        $cash = new Cash();
        $bankAccount = BankAccount::find($request->account);
        $accTransaction = new BankAccountTransaction();

        try{
            DB::transaction(function () use($request, $loanAccount, $loanTransaction, $cash, $bankAccount, $accTransaction){
                $loanAccount->emi_given = $request->emi_no;
                $loanAccount->total_paid += $request->emi;

                if($loanAccount->total_emi == $loanAccount->emi_given)
                {
                    $loanAccount->is_paid = 1;
                }

                $loanTransaction->bank_loan_id = $loanAccount->id;
                $loanTransaction->emi_date = Carbon::parse($request->emi_date)->format('Y-m-d');
                $loanTransaction->payment_type = $request->payment_type;
                $loanTransaction->bank_account_id = $request->account;
                $loanTransaction->emi_no = $request->emi_no;
                $loanTransaction->emi_amount = $request->emi;
                
                if($request->payment_type === 'cash')
                {
                    $cash->date = $loanTransaction->emi_date;
                    $cash->expense = $loanTransaction->emi_amount;
                    $cash->description = 'Given Bank Loan EMI To Account No ' . $loanAccount->account_number . ' of ' . $loanAccount->bank->name;
                    $cash->save();
                }
                else
                {
                    if($bankAccount->balance < $request->emi)
                    {
                        //message not showing in $e->getMessage(); No solution found. check later...
                        throw ValidationException::withMessages(['error' => "You don't have sufficient balance in your Bank Account !"]);
                    }
                    $bankAccount->balance -= $loanTransaction->emi_amount;
                    $bankAccount->save();
        
                    $accTransaction->bank_account_id = $bankAccount->id;
                    $accTransaction->transaction_date = $loanTransaction->emi_date;
                    $accTransaction->withdraw = $loanTransaction->emi_amount;
                    $accTransaction->balance =  $bankAccount->balance;
                    $accTransaction->description = 'Given Bank Loan EMI To Account No ' . $loanAccount->account_number . ' of ' . $loanAccount->bank->name;               
                    $accTransaction->save();
                }
                $loanAccount->save();
                $loanTransaction->save();
            }, 3);

        }
        catch(ValidationException $e)
        {
            Toastr::error("You don't have sufficient balance in your Bank Account !" ,'Error');
            //Toastr::error($e->getMessage() ,'Error');

            return redirect()->back();
        }
        catch(\Exception $ex)
        {

            //Toastr::error('Something went wrong ! Try again...' ,'Error');
            Toastr::error($ex->getMessage() ,'Error');

            return redirect()->back();
        }

        Toastr::success('EMI Payment Successful !' ,'Success');

        return redirect()->route('admin.loan.index');

    }

    public function closeLoan(Request $request, $id)
    { 
        $this->validate($request,[
            'closing_amount' => 'required|numeric',            
            'closing_bank' => 'required_if:closing_payment_type,==,cheque|integer',
            'closing_account' => 'required_if:closing_payment_type,==,cheque|integer', 
            'closing_payment_type' => 'required',            
            'closing_emi_date' => 'required|date'         
        ]);
        
        $loanAccount = BankLoan::findOrFail($id);
        $loanTransaction = new BankLoanTransaction();
        $cash = new Cash();
        $bankAccount = BankAccount::find($request->closing_account);
        $accTransaction = new BankAccountTransaction();

        try{
            DB::transaction(function () use($request, $loanAccount, $loanTransaction, $cash, $bankAccount, $accTransaction){
                $loanAccount->emi_given = $loanAccount->emi_given + 1;
                $loanAccount->total_paid += $request->closing_amount;
                $loanAccount->is_paid = 1;
                

                $loanTransaction->bank_loan_id = $loanAccount->id;
                $loanTransaction->emi_date = Carbon::parse($request->closing_emi_date)->format('Y-m-d');
                $loanTransaction->payment_type = $request->closing_payment_type;
                $loanTransaction->bank_account_id = $request->closing_account;
                $loanTransaction->emi_no = $loanAccount->emi_given;
                $loanTransaction->emi_amount = $request->closing_amount;
                
                if($request->closing_payment_type === 'cash')
                {
                    $cash->date = $loanTransaction->emi_date;
                    $cash->expense = $loanTransaction->emi_amount;
                    $cash->description = 'Given Bank Loan Closing Amount To Account No ' . $loanAccount->account_number . ' of ' . $loanAccount->bank->name;
                    $cash->save();
                }
                else
                {
                    if($bankAccount->balance < $request->closing_amount)
                    {
                        //message not showing in $e->getMessage(); No solution found. check later...
                        throw ValidationException::withMessages(['error' => "You don't have sufficient balance in your Bank Account !"]);
                    }
                    $bankAccount->balance -= $loanTransaction->emi_amount;
                    $bankAccount->save();
        
                    $accTransaction->bank_account_id = $bankAccount->id;
                    $accTransaction->transaction_date = $loanTransaction->emi_date;
                    $accTransaction->withdraw = $loanTransaction->emi_amount;
                    $accTransaction->balance =  $bankAccount->balance;
                    $accTransaction->description = 'Given Bank Loan Closing Amount To Account No ' . $loanAccount->account_number . ' of ' . $loanAccount->bank->name;               
                    $accTransaction->save();
                }
                $loanAccount->save();
                $loanTransaction->save();
            }, 3);

        }
        catch(ValidationException $e)
        {
            Toastr::error("You don't have sufficient balance in your Bank Account !" ,'Error');
            //Toastr::error($e->getMessage() ,'Error');

            return redirect()->back();
        }
        catch(\Exception $ex)
        {

            //Toastr::error('Something went wrong ! Try again...' ,'Error');
            Toastr::error($ex->getMessage() ,'Error');

            return redirect()->back();
        }

        Toastr::success('Loan Closing Payment Successful !' ,'Success');

        return redirect()->route('admin.loan.index');
    }
}
