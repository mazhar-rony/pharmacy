<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Cash;
use App\Debtor;
use App\Invoice;
use App\Product;
use App\Category;
use App\Customer;
use App\Purchase;
use Carbon\Carbon;
use App\BankAccount;
use App\InvoiceDetail;
use Illuminate\Http\Request;
use App\BankAccountTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::latest()->get();

        return view('admin.invoice.index', compact('invoices'));
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
        //$invoice_no = Invoice::whereDate('created_at', new \DateTime('today',))->max('invoice_no');
        $invoice_no = Invoice::whereDate('date', new \DateTime('today',))->max('invoice_no');

        if($invoice_no != NULL)
        {
            $invoice_no += 1;
        }
        else
        {
            // Here Date is in UTC timezone so added +6 hours to make local timezone
            $invoice_no = (int)(date('Y').date('m').date('d', strtotime('+6 hours'))."0001");
        }
        

        return view('admin.invoice.createnew', compact('categories', 'banks', 'customers', 'invoice_no'));
    }

    public function getPurchaseNo(Request $request)
    {
        $purchase_no = Purchase::whereDate('date', new \DateTime($request->purchase_date,))->max('purchase_no');

        if($purchase_no != NULL)
        {
            $purchase_no += 1;
        }
        else
        {   
            $purchase_date = Carbon::parse($request->purchase_date)->format('Y-m-d');
            $purchase_date = Carbon::parse($purchase_date);
            //return gettype($invoice_date);
            $purchase_no = (int)(substr($purchase_date, 0, 4).substr($purchase_date, 5, 2).substr($purchase_date, 8, 2)."01");
        }

        return response()->json($purchase_no);
    }

    public function getInvoice(Request $request)
    {
        $invoice_no = Invoice::whereDate('date', new \DateTime($request->invoice_date,))->max('invoice_no');

        if($invoice_no != NULL)
        {
            $invoice_no += 1;
        }
        else
        {   
            $invoice_date = Carbon::parse($request->invoice_date)->format('Y-m-d');
            $invoice_date = Carbon::parse($invoice_date);
            //return gettype($invoice_date);
            $invoice_no = (int)(substr($invoice_date, 0, 4).substr($invoice_date, 5, 2).substr($invoice_date, 8, 2)."0001");
        }

        return response()->json($invoice_no);
    }

    public function getProducts(Request $request)
    {
        $category = $request->category;
        
        if($request->has('category'))
        {
            $products =  Category::find($category)->products()->get();
            
            return response()->json($products);
            //return Category::find($request->category)->products()->get();
        }
    }

    public function getQuantity(Request $request)
    {
        if($request->has('product'))
        {
            $quantity = Product::where('id', $request->product)->first();

            return response()->json($quantity);
        }
    }

    public function getBankAccounts(Request $request)
    {
        $bank = $request->bank;
        
        if($request->has('bank'))
        {
            $accounts =  Bank::find($bank)->accounts()->get();
            
            return response()->json($accounts);
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
            'invoice' => 'required',
            'invoice_date' => 'required|date',            
            'quantity.*' => 'required|integer',
            'unit_price.*' => 'required|numeric',
            'discount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'total_paid' => 'required|numeric',
            'total_due' => 'required|numeric',
            'customer' => 'required|integer',
            'payment_type' => 'required', 
            'bank' => 'required_if:payment_type,==,cheque|integer',
            //'account' => 'required_if:payment_type,==,cheque|integer'
        ]);

        $this->saveInvoice($request);
        
        Toastr::success('Invoice Successfully Created !' ,'Success');

        return redirect()->route('admin.invoice.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::find($id);
        $invoiceDetails = $invoice->invoice_details;

        return view('admin.invoice.show', compact('invoice', 'invoiceDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $categories = Category::orderBy('name')->get();
        $banks = Bank::orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();
        $invoiceDetails = $invoice->invoice_details;
        
        return view('admin.invoice.edit', compact('invoice', 'categories', 'banks', 'customers', 'invoiceDetails'));
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
            'invoice' => 'required',
            'invoice_date' => 'required|date',            
            'quantity.*' => 'required|integer',
            'unit_price.*' => 'required|numeric',
            'discount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'total_paid' => 'required|numeric',
            'total_due' => 'required|numeric',
            'customer' => 'required|integer',
            'payment_type' => 'required', 
            'bank' => 'required_if:payment_type,==,cheque|integer',
            //'account' => 'required_if:payment_type,==,cheque|integer'
        ]);
        
        $this->deleteInvoice($id);
        $this->saveInvoice($request);

        Toastr::success('Invoice Successfully Updated !' ,'Success');

        return redirect()->route('admin.invoice.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->deleteInvoice($id);
                
        Toastr::success('Invoice Successfully Deleted !' ,'Success');

        return redirect()->back();
    }

    public function saveInvoice(Request $request)
    {        
        $cash = new Cash();
        $bankAccount = BankAccount::find($request->account);
        $accTransaction = new BankAccountTransaction();
        $invoice = new Invoice();

        try{
            DB::transaction(function () use($request, $invoice, $cash, $bankAccount, $accTransaction){

                $invoice->user_id = Auth::user()->id;
                $invoice->invoice_no = $request->invoice;
                $invoice->date = Carbon::parse($request->invoice_date)->format('Y-m-d');
                $invoice->payment_type = $request->payment_type;
                $invoice->bank_account_id = $request->account;
                $invoice->amount = $request->total_amount + $request->discount;
                $invoice->discount = $request->discount;
                $invoice->total_amount = $request->total_amount;
                $invoice->paid = $request->total_paid;
                $invoice->due = $request->total_due;
                $invoice->description = $request->description;
                $invoice->customer_id = $request->customer;

                $product_cost = 0;

                $count_products = count($request->product);
                //$count_products = $request->product->count();
                for($i=0; $i<$count_products; $i++)
                {
                    $product_cost += ($request->quantity[$i] * $request->cost[$i]);
                }

                $invoice->profit = $request->total_amount - $product_cost;

                if($invoice->due == 0)
                {
                    $invoice->is_paid = 1;
                }

                $invoice->save();

                if($request->total_due != 0)
                {
                    $debtor = new Debtor();
        
                    $debtor->customer_id = $request->customer;
                    $debtor->invoice_id = $invoice->id;
                    $debtor->debit_amount = $request->total_due;
                    $debtor->due = $request->total_due;
                    $debtor->debit_date = Carbon::parse($request->invoice_date)->format('Y-m-d');
                    $debtor->description = 'INV-' . $request->invoice;

                    $debtor->save();
                }                

                for($i=0; $i<$count_products; $i++)
                {
                    $invoice_detail = new InvoiceDetail();

                    $invoice_detail->invoice_id = $invoice->id;
                    $invoice_detail->product_id = $request->product[$i];
                    $invoice_detail->quantity = $request->quantity[$i];
                    $invoice_detail->cost = $request->cost[$i];
                    $invoice_detail->selling_price = $request->unit_price[$i];

                    $invoice_detail->save();

                    $product = Product::find($invoice_detail->product_id);

                    $product->quantity -= $invoice_detail->quantity;

                    $product->save();
                }

                if($request->payment_type === 'cash' && $request->total_paid > 0)
                {
                    $cash->date = $invoice->date;
                    $cash->income = $invoice->paid;
                    $cash->description = 'Sold Product of Invoice No INV-' . $invoice->invoice_no;
                    $cash->save();
                }
                if($request->payment_type === 'cheque' && $request->total_paid > 0)
                {
                    $bankAccount->balance += $invoice->paid;
                    $bankAccount->save();

                    $accTransaction->bank_account_id = $bankAccount->id;
                    $accTransaction->transaction_date = $invoice->date;
                    $accTransaction->deposite = $invoice->paid;
                    $accTransaction->balance =  $bankAccount->balance;
                    $accTransaction->description =  'Sold Product of Invoice No INV-' . $invoice->invoice_no;               
                    $accTransaction->save();
                }
            }, 3);

        }
        catch(\Exception $ex)
        {

            //Toastr::error('Something went wrong ! Try again...' ,'Error');
            Toastr::error($ex->getMessage() ,'Error');

            return redirect()->back();
        }
    }

    public function deleteInvoice($id)
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
