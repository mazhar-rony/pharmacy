<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Cash;
use DateTime;
use App\Invoice;
use App\Purchase;
use Carbon\Carbon;
use App\Proprietor;
use App\BankAccount;
use App\InvoiceDetail;
use App\OfficeExpense;
use App\ReturnProduct;
use App\PurchaseDetail;
use App\EmployeePayment;
use App\ReturnProductDetail;
use Illuminate\Http\Request;
use App\ProprietorTransaction;
use App\BankAccountTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function soldProducts()
    {
        return view('admin.report.sold.sold');
    }

    public function showSoldProducts(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        // $soldProducts = DB::table("invoice_details")
        //                 ->select(DB::raw("SUM(quantity) AS quantity, product_id"))
        //                 ->groupBy("product_id")
        //                 ->whereBetween('created_at', [$start_date,  $end_date])
        //                 ->get();
        
        //$soldProducts = InvoiceDetail::groupBy('product_id')->select('product_id', DB::raw('SUM(quantity) AS quantity'))->whereBetween('created_at', [$start_date,  $end_date])->pluck('quantity','product_id');
        //$soldProducts = InvoiceDetail::groupBy('product_id')->select('product_id', DB::raw('SUM(quantity) AS quantity'))->whereBetween('created_at', [$start_date,  $end_date])->orderBy('quantity','DESC')->get();
                
        $invoice = Invoice::whereBetween('date', [$start_date,  $end_date])->pluck('id')->toArray();
        
        /*$soldProducts = InvoiceDetail::groupBy('product_id')
                        ->select('product_id', DB::raw('SUM(quantity) AS quantity'))
                        ->whereIn('invoice_id', $invoice)
                        ->orderBy('quantity','DESC')
                        ->get();*/
        $soldProducts = InvoiceDetail::groupBy('product_id')
                        ->select('product_id', DB::raw('SUM(quantity) AS quantity'), 
                            DB::raw('SUM(quantity * cost) AS cost'), DB::raw('SUM(quantity * selling_price) AS price'))
                        ->whereIn('invoice_id', $invoice)
                        ->orderBy('quantity','DESC')
                        ->get();

        $show_start_date = Carbon::parse($start_date)->format('l d F Y');
        $show_end_date = Carbon::parse($end_date)->format('l d F Y');
        $total_sold_products = InvoiceDetail::whereIn('invoice_id', $invoice)->sum('quantity');
        
        return view('admin.report.sold.sold_report', 
            compact('soldProducts', 'show_start_date', 'show_end_date', 'total_sold_products'));
    }

    public function returnProducts()
    {
        return view('admin.report.return.return');
    }

    public function showReturnProducts(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $return = ReturnProduct::whereBetween('date', [$start_date,  $end_date])->pluck('id')->toArray();
        
        /*$returnProducts = ReturnProductDetail::groupBy('product_id')
                        ->select('product_id', DB::raw('SUM(quantity) AS quantity'))
                        ->whereIn('return_product_id', $return)
                        ->orderBy('quantity','DESC')
                        ->get();*/
        $returnProducts = ReturnProductDetail::groupBy('product_id')
                        ->select('product_id', DB::raw('SUM(quantity) AS quantity'),
                            DB::raw('SUM(quantity * price) AS amount'))
                        ->whereIn('return_product_id', $return)
                        ->orderBy('quantity','DESC')
                        ->get();

        $show_start_date = Carbon::parse($start_date)->format('l d F Y');
        $show_end_date = Carbon::parse($end_date)->format('l d F Y');
        $total_return_products = ReturnProductDetail::whereIn('return_product_id', $return)->sum('quantity');
        
        return view('admin.report.return.return_report', 
            compact('returnProducts', 'show_start_date', 'show_end_date', 'total_return_products'));
    }

    public function purchaseProducts()
    {
        return view('admin.report.purchase.purchase');
    }

    public function showPurchaseProducts(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $purchase = Purchase::whereBetween('date', [$start_date,  $end_date])->pluck('id')->toArray();
        
        /*$purchaseProducts = PurchaseDetail::groupBy('product_id')
                        ->select('product_id', DB::raw('SUM(quantity) AS quantity'))
                        ->whereIn('purchase_id', $purchase)
                        ->orderBy('quantity','DESC')
                        ->get();*/
        $purchaseProducts = PurchaseDetail::groupBy('product_id')
                        ->select('product_id', DB::raw('SUM(quantity) AS quantity'), 
                            DB::raw('SUM(quantity * cost) AS cost'))
                        ->whereIn('purchase_id', $purchase)
                        ->orderBy('quantity','DESC')
                        ->get();

        $show_start_date = Carbon::parse($start_date)->format('l d F Y');
        $show_end_date = Carbon::parse($end_date)->format('l d F Y');
        $total_purchase_products = PurchaseDetail::whereIn('purchase_id', $purchase)->sum('quantity');
        
        return view('admin.report.purchase.purchase_report', 
            compact('purchaseProducts', 'show_start_date', 'show_end_date', 'total_purchase_products'));
    }

    public function dailyCash()
    {
        return view('admin.report.cash.cash');
    }

    public function showDailyCash(Request $request)
    {
        if(isset($request->date))
        {
            $date = Carbon::parse($request->date)->format('Y-m-d');
        
            $cashes = Cash::where('date', $date)->orderBy('id')->get();
        }
        else
        {
            $date = date('Y-m-d');

            $cashes = Cash::where('date', $date)->orderBy('id')->get();
        }
        
        $show_date = Carbon::parse($date)->format('d F Y');
        $total_income = $cashes->sum('income');
        $total_expense = $cashes->sum('expense');

        $income = Cash::whereDate('date', '<=', $date)->sum('income');
        $expense = Cash::whereDate('date', '<=', $date)->sum('expense');
        $cashInStore = $income - $expense;
        
        return view('admin.report.cash.cash_report', 
                compact('cashes', 'show_date', 'total_income', 'total_expense', 'cashInStore'));
    }

    public function sales()
    {
        return view('admin.report.sales.sales');
    }

    public function showSales(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $sales = Invoice::groupBy('date')
                        ->select('date', DB::raw('SUM(total_amount) AS amount'), DB::raw('SUM(profit) AS profit'))
                        ->whereBetween('date', [$start_date,  $end_date])
                        ->orderBy('date')
                        ->orderBy('invoice_no')
                        ->get();

        $show_start_date = Carbon::parse($start_date)->format('d F Y');
        $show_end_date = Carbon::parse($end_date)->format('d F Y');

        $total_sales = Invoice::whereBetween('date', [$start_date,  $end_date])->sum('total_amount');
        $total_profit = Invoice::whereBetween('date', [$start_date,  $end_date])->sum('profit');
        
        return view('admin.report.sales.sales_report', 
            compact('sales', 'show_start_date', 'show_end_date', 'total_sales', 'total_profit'));
    }

    public function purchases()
    {
        return view('admin.report.purchases.purchases');
    }

    public function showPurchases(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $purchases = Purchase::groupBy('date')
                        ->select('date', DB::raw('SUM(total_amount) AS amount'))
                        ->whereBetween('date', [$start_date,  $end_date])
                        ->orderBy('date')
                        ->orderBy('purchase_no')
                        ->get();

        $show_start_date = Carbon::parse($start_date)->format('l d F Y');
        $show_end_date = Carbon::parse($end_date)->format('l d F Y');

        $total_cost = Purchase::whereBetween('date', [$start_date,  $end_date])->sum('total_amount');
        
        return view('admin.report.purchases.purchases_report', 
            compact('purchases', 'show_start_date', 'show_end_date', 'total_cost'));
    }

    public function salesDetails()
    {
        return view('admin.report.sales_details.sales_details');
    }

    public function showSalesDetails(Request $request)
    {
        if(isset($request->date))
        {
            $date = Carbon::parse($request->date)->format('Y-m-d');
        }
        else
        {
            $date = date('Y-m-d');
        }

        $salesDetails = Invoice::where('date', $date)
                        ->orderBy('invoice_no')
                        ->get();
        
        $show_date = Carbon::parse($date)->format('l d F Y');
        
        $total_sales = Invoice::where('date', $date)->sum('total_amount');
        $total_profit = Invoice::where('date', $date)->sum('profit');
        
        return view('admin.report.sales_details.sales_details_report', 
                compact('salesDetails', 'show_date', 'total_sales', 'total_profit'));
    }

    public function purchaseDetails()
    {
        return view('admin.report.purchase_details.purchase_details');
    }

    public function showPurchaseDetails(Request $request)
    {
        if(isset($request->date))
        {
            $date = Carbon::parse($request->date)->format('Y-m-d');
        }
        else
        {
            $date = date('Y-m-d');
        }

        $purchaseDetails = Purchase::where('date', $date)
                        ->orderBy('purchase_no')
                        ->get();
        
        $show_date = Carbon::parse($date)->format('l d F Y');
        
        $total_cost = Purchase::where('date', $date)->sum('total_amount');
        
        return view('admin.report.purchase_details.purchase_details_report', 
                compact('purchaseDetails', 'show_date', 'total_cost'));
    }

    public function proprietorExpenses()
    {
        $proprietors = Proprietor::orderBy('name')->get();

        return view('admin.report.proprietor.proprietor', compact('proprietors'));
    }

    public function showProprietorExpenses(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'proprietor' => 'required|integer'
        ]);

        $proprietors = Proprietor::orderBy('name')->get();

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $proprietorExpenses = ProprietorTransaction::where('proprietor_id', $request->proprietor)
                                ->where('withdraw', '>', 0)
                                ->whereBetween('transaction_date', [$start_date,  $end_date])
                                ->orderBy('transaction_date')
                                ->get();
                            
        $show_start_date = Carbon::parse($start_date)->format('l d F Y');
        $show_end_date = Carbon::parse($end_date)->format('l d F Y');

        $totalExpense = ProprietorTransaction::where('proprietor_id', $request->proprietor)
                        ->whereBetween('transaction_date', [$start_date,  $end_date])
                        ->sum('withdraw');

        return view('admin.report.proprietor.proprietor_report', 
                    compact('proprietors', 'proprietorExpenses', 'show_start_date', 'show_end_date', 'totalExpense'));
    }

    public function officeExpenses()
    {
        return view('admin.report.office.office');
    }

    public function showOfficeExpenses(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $officeExpenses = OfficeExpense::whereBetween('date', [$start_date,  $end_date])
                                        ->orderBy('date')
                                        ->get();
                            
        $show_start_date = Carbon::parse($start_date)->format('l d F Y');
        $show_end_date = Carbon::parse($end_date)->format('l d F Y');

        $totalExpense = OfficeExpense::whereBetween('date', [$start_date,  $end_date])
                                                ->sum('expense');

        return view('admin.report.office.office_report', 
                    compact('officeExpenses', 'show_start_date', 'show_end_date', 'totalExpense'));
    }

    public function bankTransactions()
    {
        $banks = Bank::orderBy('name')->get();

        return view('admin.report.bank.bank', compact('banks'));
    }

    public function showBankTransactions(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'bank' => 'required|integer',
            'account' => 'required|integer'
        ]);

        $banks = Bank::orderBy('name')->get();

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $accounts = BankAccountTransaction::where('bank_account_id', $request->account)
                                            ->whereBetween('transaction_date', [$start_date,  $end_date])
                                            ->orderBy('transaction_date', 'DESC')
                                            ->orderBy('id', 'DESC')
                                            ->get();

        $show_start_date = Carbon::parse($start_date)->format('l d F Y');
        $show_end_date = Carbon::parse($end_date)->format('l d F Y');

        $account = BankAccount::find($request->account);
        
        return view('admin.report.bank.bank_report', 
                        compact('banks', 'accounts', 'show_start_date', 'show_end_date', 'account'));
    }

    public function employeeSalary()
    {
        return view('admin.report.salary.salary');
    }

    public function showEmployeeSalary(Request $request)
    {
        $this->validate($request, [
            'year' => 'required|integer',
            'month' => 'required|integer'
        ]);

        $employees = EmployeePayment::groupBy('employee_id')
                    ->select('employee_id', DB::raw('SUM(salary) AS salary, SUM(advance_deduct) AS advance_deduct, SUM(bonus) AS bonus'))
                    ->where('year', $request->year)
                    ->where('month', $request->month)
                    ->orderBy('employee_id')
                    ->get();

        $salaryYear = $request->year;
        $dateObj   = DateTime::createFromFormat('!m', $request->month);
        $monthName = $dateObj->format('F');
        
        return view('admin.report.salary.salary_report', 
                    compact('employees', 'salaryYear', 'monthName'));
    }
}
