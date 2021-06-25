<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Cash;
use App\Product;
use App\Category;
use App\Creditor;
use App\Purchase;
use App\Supplier;
use Carbon\Carbon;
use App\BankAccount;
use App\PurchaseDetail;
use Illuminate\Http\Request;
use App\BankAccountTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::latest()->get();

        return view('admin.purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $banks = Bank::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $income = DB::table('cashes')->sum('income');
        $expense = DB::table('cashes')->sum('expense');
        $cash = $income - $expense; 
        //$purchase_no = Purchase::whereDate('created_at', new \DateTime('today',))->max('purchase_no');
        $purchase_no = Purchase::whereDate('date', new \DateTime('today',))->max('purchase_no');

        if($purchase_no != NULL)
        {
            $purchase_no += 1;
        }
        else
        {
            // Here Date is in UTC timezone so added +6 hours to make local timezone
            $purchase_no = (int)(date('Y').date('m').date('d', strtotime('+6 hours'))."01");
        }
        

        return view('admin.purchase.create', compact('categories', 'banks', 'suppliers', 'purchase_no', 'cash'));
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
            'purchase' => 'required',
            'purchase_date' => 'required|date',
            'quantity.*' => 'required|integer',
            'unit_price.*' => 'required|numeric',
            'discount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'total_paid' => 'required|numeric',
            'total_due' => 'required|numeric',
            'supplier' => 'required|integer',
            'payment_type' => 'required', 
            'bank' => 'required_if:payment_type,==,cheque|integer',
            //'account' => 'required_if:payment_type,==,cheque|integer'
        ]);
        
        if($request->total_paid > $request->total_amount)
        {
            Toastr::error('Trying to pay more than Net Amount !' ,'Error');
            return redirect()->back();
        }

        $this->savePurchase($request);

        Toastr::success('Purchase Successfully Created !' ,'Success');

        return redirect()->route('admin.purchase.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchaseDetails = $purchase->purchase_details;

        return view('admin.purchase.show', compact('purchase', 'purchaseDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = Purchase::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $banks = Bank::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $purchaseDetails = $purchase->purchase_details;
        $income = DB::table('cashes')->sum('income');
        $expense = DB::table('cashes')->sum('expense');
        $cash = $income - $expense;
        
        return view('admin.purchase.edit', compact('purchase', 'categories', 'banks', 'suppliers', 'purchaseDetails', 'cash'));
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
            'purchase' => 'required',
            'purchase_date' => 'required|date',
            'quantity.*' => 'required|integer',
            'unit_price.*' => 'required|numeric',
            'discount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'total_paid' => 'required|numeric',
            'total_due' => 'required|numeric',
            'supplier' => 'required|integer',
            'payment_type' => 'required', 
            'bank' => 'required_if:payment_type,==,cheque|integer',
            //'account' => 'required_if:payment_type,==,cheque|integer'
        ]);
        
        if($request->total_paid > $request->total_amount)
        {
            Toastr::error('Trying to pay more than Net Amount !' ,'Error');
            return redirect()->back();
        }

        $this->deletePurchase($id);
        $this->savePurchase($request);
        
        Toastr::success('Purchase Successfully Updated !' ,'Success');

        return redirect()->route('admin.purchase.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->deletePurchase($id);

        Toastr::success('Purchase Successfully Deleted !' ,'Success');

        return redirect()->back();
    }

    public function savePurchase(Request $request)
    {
        $cash = new Cash();
        $bankAccount = BankAccount::find($request->account);
        $accTransaction = new BankAccountTransaction();
        $purchase = new Purchase();

        try{
            DB::transaction(function () use($request, $purchase, $cash, $bankAccount, $accTransaction){

                $purchase->user_id = Auth::user()->id;
                $purchase->purchase_no = $request->purchase;
                $purchase->date = Carbon::parse($request->purchase_date)->format('Y-m-d');
                $purchase->payment_type = $request->payment_type;
                $purchase->bank_account_id = $request->account;
                $purchase->amount = $request->total_amount + $request->discount;
                $purchase->discount = $request->discount;
                $purchase->total_amount = $request->total_amount;
                $purchase->paid = $request->total_paid;
                $purchase->due = $request->total_due;
                $purchase->description = $request->description;
                $purchase->supplier_id = $request->supplier;

                if($purchase->due == 0)
                {
                    $purchase->is_paid = 1;
                }

                $purchase->save();

                if($request->total_due != 0)
                {
                    $creditor = new Creditor();
        
                    $creditor->supplier_id = $request->supplier;
                    $creditor->purchase_id = $purchase->id;
                    $creditor->credit_amount = $request->total_due;
                    $creditor->due = $request->total_due;
                    $creditor->credit_date = Carbon::parse($request->purchase_date)->format('Y-m-d');
                    $creditor->description = 'P-' . $request->purchase;

                    $creditor->save();
                }   
                
                $count_products = count($request->product);

                for($i=0; $i<$count_products; $i++)
                {
                    $purchase_detail = new PurchaseDetail();

                    $purchase_detail->purchase_id = $purchase->id;
                    $purchase_detail->product_id = $request->product[$i];
                    $purchase_detail->quantity = $request->quantity[$i];
                    $purchase_detail->cost = $request->unit_price[$i];

                    $purchase_detail->save();

                    $product = Product::find($purchase_detail->product_id);

                    $oldPrice = $product->price * $product->quantity;
                    $newPrice = $request->unit_price[$i] * $request->quantity[$i];
                    $avgPrice = ($oldPrice + $newPrice) / ($product->quantity + $request->quantity[$i]);

                    $product->price = $avgPrice;

                    $product->quantity += $request->quantity[$i];

                    $product->save();
                }

                if($request->payment_type === 'cash' && $request->total_paid > 0)
                {
                    $cash->date = $purchase->date;
                    $cash->expense = $purchase->paid;
                    $cash->description = 'Purchased Product of Purchase No P-' . $purchase->purchase_no;
                    $cash->save();
                }
                if($request->payment_type === 'cheque' && $request->total_paid > 0)
                {
                    if($bankAccount->balance < $request->total_paid)
                    {
                        //message not showing in $e->getMessage(); No solution found. check later...
                        throw ValidationException::withMessages(['error' => "You don't have sufficient balance in your Bank Account !"]);
                    }
                    $bankAccount->balance -= $purchase->paid;
                    $bankAccount->save();

                    $accTransaction->bank_account_id = $bankAccount->id;
                    $accTransaction->transaction_date = $purchase->date;
                    $accTransaction->withdraw = $purchase->paid;
                    $accTransaction->balance =  $bankAccount->balance;
                    $accTransaction->description =  'Purchased Product of Purchase No P-' . $purchase->purchase_no;               
                    $accTransaction->save();
                }
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
    }

    public function deletePurchase($id)
    {
        $purchase = Purchase::findOrFail($id);
        $account = BankAccountTransaction::where('description', 'like', '%' . $purchase->purchase_no . '%')->first();
       
        try{
            DB::transaction(function () use($purchase, $account){
                if($purchase->payment_type === 'cash')
                {
                    Cash::where('description', 'like', '%' . $purchase->purchase_no . '%')->delete();
                }
                if($purchase->payment_type === 'cheque' && $account !== null)
                {                    
                    $bankAccount = BankAccount::find($account->bank_account_id);
                    $bankAccount->balance += $purchase->paid;
                    BankAccountTransaction::where('description', 'like', '%' . $purchase->purchase_no . '%')->delete();
                    $bankAccount->save();
                }
                $purchaseDetails = PurchaseDetail::where('purchase_id', $purchase->id)->get();
                foreach($purchaseDetails as $purchaseDetail)
                {
                    $product = Product::find($purchaseDetail->product_id);
                    $product->quantity -= $purchaseDetail->quantity;
                    $product->save();
                }
                $purchase->delete();
            }, 3);

        }
        catch(\Exception $ex)
        {

            //Toastr::error('Something went wrong ! Try again...' ,'Error');
            Toastr::error($ex->getMessage() ,'Error');

            return redirect()->back();
        }
    }
}
