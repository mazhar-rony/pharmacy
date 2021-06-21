<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\Debtor;
use App\Invoice;
use App\Creditor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $income = DB::table('cashes')->sum('income');
        $expense = DB::table('cashes')->sum('expense');
        $cash = $income - $expense;

        $totalPending = Debtor::sum('due');

        $totalCredit = Creditor::sum('due');

        $todaySales = Invoice::where('date', Carbon::now()->toDateString())->sum('total_amount');
        
        return view('admin.dashboard', compact('cash', 'totalPending', 'totalCredit', 'todaySales'));
        
        //return view('welcome');
    }

    public function getChartData()
    {
        $sales = Invoice::groupBy('month')
        ->select(DB::raw('MONTH(date) AS month'), DB::raw('SUM(total_amount) AS sales'), DB::raw('SUM(profit) AS profit'))
        ->whereYear('date', date('Y'))
        ->orderBy('month', 'ASC')
        ->get();

        $month_name_array = array();
        $monthly_sales_array = array();
        $monthly_srofit_array = array();

        foreach($sales as $sale)
        {
            array_push($month_name_array, DateTime::createFromFormat('!m', $sale->month)->format('F'));
            array_push($monthly_sales_array, round($sale->sales, 0));
            array_push($monthly_srofit_array, round($sale->profit, 0));
        }
       
        $monthly_data_array = array(
			'months' => $month_name_array,
			'sales_data' => $monthly_sales_array,
			'profit_data' => $monthly_srofit_array
		);

        return $monthly_data_array;
    }
}
