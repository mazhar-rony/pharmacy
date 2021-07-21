<?php

namespace App\Http\Controllers\User;

use App\Cash;
use Carbon\Carbon;
use App\OfficeExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class OfficeExpenseController extends Controller
{
    public function create()
    {
        $income = DB::table('cashes')->sum('income');
        $expense = DB::table('cashes')->sum('expense');
        $cash = $income - $expense;
        
        return view('user.office_expense.create', compact('cash'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'expense' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'required'
        ]);

        $officeExpense = new OfficeExpense();
        $cash = new Cash();

        try{
            DB::transaction(function () use($request, $officeExpense, $cash){
                $officeExpense->expense = $request->expense;
                $officeExpense->date = Carbon::parse($request->date)->format('Y-m-d');
                $officeExpense->description = 'Cost for: '.$request->description;
                $officeExpense->save();

                $cash->expense = $request->expense;
                $cash->date = Carbon::parse($request->date)->format('Y-m-d');
                $cash->description = 'Cost for: '.$request->description;
                $cash->save();

            }, 3);

        }
        catch(\Exception $ex)
        {

            //Toastr::error('Something went wrong ! Try again...' ,'Error');
            Toastr::error($ex->getMessage() ,'Error');

            return redirect()->back();
        }

        Toastr::success('Successfully Withdrawn !' ,'Success');

        return redirect()->back();
    }
}
