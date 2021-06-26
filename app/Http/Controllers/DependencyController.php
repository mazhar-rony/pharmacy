<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Invoice;
use App\Product;
use App\Category;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DependencyController extends Controller
{
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

    public function getBranches(Request $request)
    {
        if($request->has('bank'))
        {
            return Bank::find($request->bank)->branches()->get();
            //return \DB::table('bank_branches')->where('bank_id', $request->bank)->get();
        }
    }

    public function getCustomer(Request $request)
    {
        $invoice = $request->invoice;

        if($request->has('invoice'))
        {
            $customer = Invoice::find($invoice)->customer()->first();

            return response()->json($customer);
        }
    }

    public function getEmployeeSalary(Request $request)
    {
        $salary = DB::table('employee_payments')->where('employee_id', $request->employee_id)
                                                ->where('year', $request->salary_year)
                                                ->where('month', $request->salary_month)
                                                ->sum('salary');
        $deduct = DB::table('employee_payments')->where('employee_id', $request->employee_id)
                                                ->where('year', $request->salary_year)
                                                ->where('month', $request->salary_month)
                                                ->sum('advance_deduct');
        $totalPaid = round(($salary + $deduct), 2);
        
        return $totalPaid;
    }
}
