<?php

namespace App\Http\Controllers\User;

use App\Bank;
use App\Cash;
use App\Debtor;
use App\Invoice;
use App\Product;
use App\Category;
use App\Customer;
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
    public function index()
    {
        $invoices = Invoice::whereDate('date', '>', Carbon::now()->subDays(7))->orWhere('is_paid', 0)
                            ->orderBy('date', 'DESC')
                            ->get();

        return view('user.invoice.index', compact('invoices'));
    }

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
            //$invoice_no = (int)(date('Y').date('m').date('d', strtotime('+6 hours'))."0001");
            $invoice_no = (int)(date('Y').date('m').date('d')."0001");
        }
        

        return view('user.invoice.create', compact('categories', 'banks', 'customers', 'invoice_no'));
    }

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

        return redirect()->route('user.invoice.index');

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

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceDetails = $invoice->invoice_details;

        return view('user.invoice.show', compact('invoice', 'invoiceDetails'));
    }
}
