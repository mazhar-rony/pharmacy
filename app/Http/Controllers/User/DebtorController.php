<?php

namespace App\Http\Controllers\User;

use App\Bank;
use App\Cash;
use App\Debtor;
use App\Invoice;
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
    public function index()
    {
        $debtors = Debtor::latest()->where('is_paid', 0)->get();

        $total_due = DB::table('debtors')->select(DB::raw('sum(round(due, 2)) AS total_due'))->first();

        return view('user.debtor.index', compact('debtors', 'total_due'));
    }

    public function payment($id)
    {
        $debtor = Debtor::findOrFail($id);

        $banks = Bank::orderBy('name')->get();

        return view('user.debtor.payment', compact('debtor', 'banks'));
    }

    public function paidByDebtor(Request $request, $id)
    {
        $this->validate($request,[
            'pay' => 'required|numeric',
            'consession' => 'required|numeric',
            'payment_date' => 'required|date'
        ]);

        $debtor = Debtor::findOrFail($id);
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
                        $cash->description = 'Taken Due Payment of Invoice No '. $debtor->description . ' From ' . $debtor->customer->name . ' of ' . $debtor->customer->organization;
                    }
                    else
                    {
                        $cash->description = 'Taken Due Payment From ' . $debtor->customer->name . ' of ' . $debtor->customer->organization;
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
                        $accTransaction->description = 'Taken Due Payment of Invoice No '. $debtor->description . ' From ' . $debtor->customer->name . ' of ' . $debtor->customer->organization;
                    }
                    else
                    {
                        $accTransaction->description = 'Taken Due Payment From ' . $debtor->customer->name . ' of ' . $debtor->customer->organization;
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

        return redirect()->route('user.debtor.index');

    }
}
