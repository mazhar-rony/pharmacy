<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Cash;
use App\Debtor;
use App\Invoice;
use App\Customer;
use Carbon\Carbon;
use App\BankAccount;
use App\DebtorPayment;
use Illuminate\Http\Request;
use App\BankAccountTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class DebtorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $debtors = Debtor::latest()->where('is_paid', 0)->get();

        $total_due = DB::table('debtors')->select(DB::raw('sum(round(due, 2)) AS total_due'))->first();

        return view('admin.debtor.index', compact('debtors', 'total_due'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();

        return view('admin.debtor.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer' => 'required|integer',
            'amount' => 'required|numeric',
            'debit_date' => 'required|date'
        ]);

        $debtor = new Debtor();
        
        $debtor->customer_id = $request->customer;
        $debtor->debit_amount = $request->amount;
        $debtor->due = $request->amount;
        $debtor->debit_date = Carbon::parse($request->debit_date)->format('Y-m-d');
        $debtor->description = $request->description;

        $debtor->save();

        Toastr::success('Debtor Successfully Created !' ,'Success');

        return redirect()->route('admin.debtor.index');
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
        $debtor = Debtor::find($id);
        $customers = Customer::orderBy('name')->get();

        return view('admin.debtor.edit', compact('debtor', 'customers'));
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
        $this->validate($request, [
            'customer' => 'required|integer',
            'debit_date' => 'required|date'
        ]);

        $debtor = Debtor::find($id);

        $debtor->customer_id = $request->customer;
        $debtor->debit_date = Carbon::parse($request->debit_date)->format('Y-m-d');
        $debtor->description = $request->description;

        $debtor->save();

        Toastr::success('Debtor Successfully Updated !' ,'Success');

        return redirect()->route('admin.debtor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $debtor = Debtor::find($id);

        $debtor->delete();

        Toastr::success('Debtor Successfully Deleted !' ,'Success');

        return redirect()->back();
    }

    public function payment($id)
    {
        $debtor = Debtor::find($id);

        $banks = Bank::orderBy('name')->get();

        return view('admin.debtor.payment', compact('debtor', 'banks'));
    }

    public function paidByDebtor(Request $request, $id)
    {
        $this->validate($request,[
            'pay' => 'required|numeric',
            'consession' => 'required|numeric',
            'payment_date' => 'required|date'
        ]);

        $debtor = Debtor::find($id);
        $payment = new DebtorPayment();
        $cash = new Cash();
        $account = BankAccount::find($request->account);
        $accTransaction = new BankAccountTransaction();
        
        try{
            DB::transaction(function () use($request, $debtor, $payment, $cash, $account, $accTransaction){
                $debtor->paid += $request->pay;
                $debtor->consession += $request->consession;
                $debtor->due -= $request->pay + $request->consession;

                if(isset($debtor->invoice_id))
                {
                    $invoice = Invoice::find($debtor->invoice_id);

                    $invoice->paid += $request->pay;
                    $invoice->due -= $request->pay + $request->consession;
                    $invoice->profit -= $request->consession;
                    if($invoice->due == 0)
                    {
                        $invoice->is_paid = 1;
                    }

                    $invoice->save();
                }
                if($debtor->due == 0)
                {
                    $debtor->is_paid = 1;
                }
                //$debtor->save();
        
                $payment->debtor_id = $debtor->id;
                $payment->payment_date = Carbon::parse($request->payment_date)->format('Y-m-d');
                $payment->payment_type = $request->payment_type;
                $payment->bank_account_id = $request->account;
                $payment->paid = $request->pay;
                //$payment->save();
                
                if($request->payment_type === 'cash')
                {
                    $cash->date = $payment->payment_date;
                    $cash->income = $payment->paid;
                    if(isset($debtor->invoice_id))
                    {
                        $cash->description = 'Taken Due Payment of '. $debtor->description . ' From ' . $debtor->customer->name;
                    }
                    else
                    {
                        $cash->description = 'Taken Due Payment From ' . $debtor->customer->name;
                    }
                    
                    $cash->save();
                }
                else
                {
                    $account->balance += $payment->paid;
                    $account->save();
        
                    $accTransaction->bank_account_id = $account->id;
                    $accTransaction->transaction_date = $payment->payment_date;
                    $accTransaction->deposite = $payment->paid;
                    $accTransaction->balance = $account->balance;
                    if(isset($debtor->invoice_id))
                    {
                        $accTransaction->description = 'Taken Due Payment of '. $debtor->description . ' From ' . $debtor->customer->name;
                    }
                    else
                    {
                        $accTransaction->description = 'Taken Due Payment From ' . $debtor->customer->name;
                    }
                                   
                    $accTransaction->save();
                }
                $debtor->save();
                $payment->save();
            }, 3);

        }
        catch(\Exception $ex)
        {

            //Toastr::error('Something went wrong ! Try again...' ,'Error');
            Toastr::error($ex->getMessage() ,'Error');

            return redirect()->back();
        }

        Toastr::success('Payment Successful !' ,'Success');

        return redirect()->route('admin.debtor.index');

    }
}
