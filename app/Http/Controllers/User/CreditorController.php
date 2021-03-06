<?php

namespace App\Http\Controllers\User;

use App\Bank;
use App\Cash;
use App\Creditor;
use App\Purchase;
use Carbon\Carbon;
use App\BankAccount;
use App\CreditorPayment;
use Illuminate\Http\Request;
use App\BankAccountTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Validation\ValidationException;

class CreditorController extends Controller
{
    public function index()
    {
        $creditors = Creditor::latest()->where('is_paid', 0)->get();

        $total_due = DB::table('creditors')->select(DB::raw('sum(round(due, 2)) AS total_due'))->first();

        return view('user.creditor.index', compact('creditors', 'total_due'));
    }

    public function payment($id)
    {
        $creditor = Creditor::findOrFail($id);

        $banks = Bank::orderBy('name')->get();

        $income = DB::table('cashes')->sum('income');
        $expense = DB::table('cashes')->sum('expense');
        $cash = $income - $expense;

        return view('user.creditor.payment', compact('creditor', 'banks', 'cash'));
    }

    public function payToCreditor(Request $request, $id)
    {
        $this->validate($request,[
            'pay' => 'required|numeric',
            'consession' => 'required|numeric',
            'payment_date' => 'required|date'
        ]);

        $creditor = Creditor::findOrFail($id);
        $payment = new CreditorPayment();
        $cash = new Cash();
        $account = BankAccount::find($request->account);
        $accTransaction = new BankAccountTransaction();
        
        try{
            DB::transaction(function () use($request, $creditor, $payment, $cash, $account, $accTransaction){
                $creditor->paid += $request->pay;
                $creditor->consession += $request->consession;
                $creditor->due -= $request->pay + $request->consession;

                if(isset($creditor->purchase_id))
                {
                    $purchase = Purchase::find($creditor->purchase_id);

                    $purchase->paid += $request->pay;
                    $purchase->due -= $request->pay + $request->consession;
                    
                    if($purchase->due == 0)
                    {
                        $purchase->is_paid = 1;
                    }

                    $purchase->save();
                }
                if($creditor->due == 0)
                {
                    $creditor->is_paid = 1;
                }
                //$creditor->save();
        
                $payment->creditor_id = $creditor->id;
                $payment->payment_date = Carbon::parse($request->payment_date)->format('Y-m-d');
                $payment->payment_type = $request->payment_type;
                $payment->bank_account_id = $request->account;
                $payment->paid = $request->pay;
                //$payment->save();
                
                if($request->payment_type === 'cash')
                {
                    $cash->date = $payment->payment_date;
                    $cash->expense = $payment->paid;

                    if(isset($creditor->purchase_id))
                    {                        
                        $cash->description = 'Given Payment of Purchase No ' . $creditor->description . ' to '. $creditor->supplier->name . ' of ' . $creditor->supplier->organization;
                    }
                    else
                    {
                        $cash->description = 'Given Payment To ' . $creditor->supplier->name . ' of ' . $creditor->supplier->organization;
                    }
                    
                    $cash->save();
                }
                else
                {
                    if($account->balance < $request->pay)
                    {
                        //message not showing in $e->getMessage(); No solution found. check later...
                        throw ValidationException::withMessages(['error' => "You don't have sufficient balance in your Bank Account !"]);
                    }
                    $account->balance -= $payment->paid;
                    $account->save();
        
                    $accTransaction->bank_account_id = $account->id;
                    $accTransaction->transaction_date = $payment->payment_date;
                    $accTransaction->withdraw = $payment->paid;
                    $accTransaction->balance = $account->balance;

                    if(isset($creditor->purchase_id))
                    {
                        $accTransaction->description = 'Given Payment of Purchase No ' . $creditor->description . ' to '. $creditor->supplier->name . ' of ' . $creditor->supplier->organization;
                    }
                    else
                    {
                        $accTransaction->description = 'Given Payment To ' . $creditor->supplier->name . ' of ' . $creditor->supplier->organization;
                    }
                                   
                    $accTransaction->save();
                }
                $creditor->save();
                $payment->save();
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

        Toastr::success('Payment Successful !' ,'Success');

        return redirect()->route('user.creditor.index');

    }
}
