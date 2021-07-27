<?php

namespace App\Http\Controllers\User;

use App\Debtor;
use App\Invoice;
use App\Product;
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

        $products = Product::where('quantity', '<=', 'low_quantity_alert')->orderBy('name')->get();
        
        return view('user.dashboard', compact('cash', 'totalPending', 'totalCredit', 'todaySales', 'products'));
        //return view('user.dashboard2');
    }
}
