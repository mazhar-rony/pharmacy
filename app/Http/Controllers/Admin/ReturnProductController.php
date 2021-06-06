<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Cash;
use App\Invoice;
use App\Product;
use App\Category;
use App\Customer;
use Carbon\Carbon;
use App\BankAccount;
use App\ReturnProduct;
use App\ReturnProductDetail;
use Illuminate\Http\Request;
use App\BankAccountTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ReturnProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returnProducts = ReturnProduct::latest()->get();

        return view('admin.return_product.index', compact('returnProducts'));
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
        $customers = Customer::orderBy('name')->get();
        $invoices = Invoice::orderBy('invoice_no')->get(); 
        $income = DB::table('cashes')->sum('income');
        $expense = DB::table('cashes')->sum('expense');
        $cash = $income - $expense;     
        //return $cash;
        return view('admin.return_product.create', compact('categories', 'banks', 'customers', 'invoices', 'cash'));
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
            'return_date' => 'required|date',
            'amount' => 'required|numeric',
            'customer' => 'required|integer',
            'payment_type' => 'required', 
            'bank' => 'required_if:payment_type,==,cheque|integer',
            //'account' => 'required_if:payment_type,==,cheque|integer'
        ]);
        
        $cash = new Cash();
        $bankAccount = BankAccount::find($request->account);
        $accTransaction = new BankAccountTransaction();
        $returnProduct = new ReturnProduct();

        try{
            DB::transaction(function () use($request, $returnProduct, $cash, $bankAccount, $accTransaction){

                $returnProduct->user_id = Auth::user()->id;
                $returnProduct->invoice_id = $request->invoice;
                $returnProduct->date = Carbon::parse($request->return_date)->format('Y-m-d');
                $returnProduct->payment_type = $request->payment_type;
                $returnProduct->bank_account_id = $request->account;
                $returnProduct->amount = $request->amount;
                $returnProduct->description = $request->description;
                $returnProduct->customer_id = $request->customer;

                $returnProduct->save();

                $count_products = count($request->product);                

                for($i=0; $i<$count_products; $i++)
                {
                    $returnProductDetail = new ReturnProductDetail();

                    $returnProductDetail->return_product_id = $returnProduct->id;
                    $returnProductDetail->product_id = $request->product[$i];
                    $returnProductDetail->quantity = $request->quantity[$i];
                    $returnProductDetail->price = $request->unit_price[$i];

                    $returnProductDetail->save();

                    $product = Product::find($returnProductDetail->product_id);

                    $product->quantity += $returnProductDetail->quantity;

                    $product->save();
                }

                if($request->payment_type === 'cash' && $request->amount > 0)
                {
                    $cash->date = $returnProduct->date;
                    $cash->expense =  $returnProduct->amount;
                    if(isset($request->invoice))
                    {
                        $cash->description = 'Return Product of Invoice No INV-' . $returnProduct->invoice->invoice_no;
                    }
                    else
                    {
                        $cash->description = 'Return Product from ' . $returnProduct->customer->name . ' of ' . $returnProduct->customer->organization;
                    }
                    
                    $cash->save();
                }
                if($request->payment_type === 'cheque' && $request->amount > 0)
                {
                    if($bankAccount->balance < $request->amount)
                    {
                        //message not showing in $e->getMessage(); No solution found. check later...
                        throw ValidationException::withMessages(['error' => "You don't have sufficient balance in your Bank Account !"]);
                    }
                    $bankAccount->balance -= $returnProduct->amount;
                    $bankAccount->save();

                    $accTransaction->bank_account_id = $bankAccount->id;
                    $accTransaction->transaction_date = $returnProduct->date;
                    $accTransaction->withdraw = $returnProduct->amount;
                    $accTransaction->balance =  $bankAccount->balance;
                    if(isset($request->invoice))
                    {
                        $accTransaction->description =  'Return Product of Invoice No INV-' . $returnProduct->invoice->invoice_no;
                    }
                    else
                    {
                        $accTransaction->description =  'Return Product from ' . $returnProduct->customer->name . ' of ' . $returnProduct->customer->organization;
                    }
                                   
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
        
        Toastr::success('Product Successfully Returned !' ,'Success');

        return redirect()->route('admin.return.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $account = BankAccountTransaction::where('description', 'like', '%' . $invoice->invoice_no . '%')->first();
       
        try{
            DB::transaction(function () use($invoice, $account){
                if($invoice->payment_type === 'cash')
                {
                    Cash::where('description', 'like', '%' . $invoice->invoice_no . '%')->delete();
                }
                if($invoice->payment_type === 'cheque' && $account !== null)
                {
                    //$account = BankAccountTransaction::where('description', 'like', '%' . $invoice->invoice_no . '%')->first();
                    $bankAccount = BankAccount::find($account->bank_account_id);
                    $bankAccount->balance -= $invoice->paid;
                    BankAccountTransaction::where('description', 'like', '%' . $invoice->invoice_no . '%')->delete();
                    $bankAccount->save();
                }
                $invoiceDetails = InvoiceDetail::where('invoice_id', $invoice->id)->get();
                foreach($invoiceDetails as $invoiceDetail)
                {
                    $product = Product::find($invoiceDetail->product_id);
                    $product->quantity += $invoiceDetail->quantity;
                    $product->save();
                }
                $invoice->delete();
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
