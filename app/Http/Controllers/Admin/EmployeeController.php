<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Cash;
use DateTime;
use App\Employee;
use Carbon\Carbon;
use App\BankAccount;
use App\EmployeePayment;
use Illuminate\Http\Request;
use App\BankAccountTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::latest()->get();

        return view('admin.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'designation' => 'required',
            'address' => 'required',
            'phone' => 'required',
            //'advance' => 'required|numeric',
            'salary' => 'required|numeric',
            'image' => 'mimes:png,jpg,jpeg,bmp'
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->name);

        if(isset($image))
        {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('employee'))
            {
                Storage::disk('public')->makeDirectory('employee');
            }

            $employeeImage = Image::make($image)->resize(500,333)->stream();

            Storage::disk('public')->put('employee/'.$imageName, $employeeImage);

        } else {
            $imageName = "default.png";
        }

        $employee = new Employee();

        $employee->name = $request->name;
        $employee->designation = $request->designation;
        $employee->address = $request->address;
        $employee->phone = $request->phone;
        //$employee->advance = $request->advance;
        $employee->salary = $request->salary;
        $employee->image = $imageName;
        
        $employee->save();
       
        Toastr::success('Employee Successfully Created !' ,'Success');

        return redirect()->route('admin.employee.index');
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
        $employee = Employee::find($id);

        return view('admin.employee.edit', compact('employee'));
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
        $this->validate($request, [
            'name' => 'required',
            'designation' => 'required',
            'address' => 'required',
            'phone' => 'required',
            //'advance' => 'required|numeric',
            'salary' => 'required|numeric',
            'image' => 'mimes:png,jpg,jpeg,bmp'
        ]);

        $employee = Employee::find($id);

        $image = $request->file('image');
        $slug = str_slug($request->name);

        if(isset($image))
        {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('employee'))
            {
                Storage::disk('public')->makeDirectory('employee');
            }

            //delete old employee image
            if(Storage::disk('public')->exists('employee/'.$employee->image) && strcmp($employee->image, "default.png") != 0)
            {
                Storage::disk('public')->delete('employee/'.$employee->image);
            }

            $employeeImage = Image::make($image)->resize(500,333)->stream();

            Storage::disk('public')->put('employee/'.$imageName, $employeeImage);

        } else {
            $imageName = $employee->image;
        }

        $employee->name = $request->name;
        $employee->designation = $request->designation;
        $employee->address = $request->address;
        $employee->phone = $request->phone;
        //$employee->advance = $request->advance;
        $employee->salary = $request->salary;
        $employee->image = $imageName;
        
        $employee->save();
       
        Toastr::success('Employee Successfully Updated !' ,'Success');

        return redirect()->route('admin.employee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        //delete employee image from folder
        if(Storage::disk('public')->exists('employee/'.$employee->image) && strcmp($employee->image, "default.png") != 0)
        {
            Storage::disk('public')->delete('employee/'.$employee->image);
        }

        $employee->delete();

        Toastr::success('Employee Successfully Deleted !' ,'Success');

        return redirect()->back();
    }

    public function payment($id)
    {
        $employee = Employee::find($id);
        $banks = Bank::orderBy('name')->get();
        $income = DB::table('cashes')->sum('income');
        $expense = DB::table('cashes')->sum('expense');
        $cash = $income - $expense;

        return view('admin.employee.payment', compact('employee', 'cash', 'banks'));
    }

    public function salary(Request $request, $id)
    {
        $this->validate($request,[
            'salary_year' => 'required|integer',
            'salary_month' => 'required|integer',
            'salary' => 'required|numeric',
            'deduct_advance' => 'required|numeric',
            'salary_date' => 'required|date'
        ]);

        if(($request->salary + $request->deduct_advance) > $request->employee_salary_due)
        {
            Toastr::error("Abort Payment ! Trying to Pay more Amount than Salary." ,'Error');
            return redirect()->back();
        }
        /* get Month Name from Number */
        $monthNum  = $request->salary_month;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F');
        /*...............................*/

        $employee = Employee::find($id);
        $payment = new EmployeePayment();
        $cash = new Cash();
        $account = BankAccount::find($request->salary_account);
        $accTransaction = new BankAccountTransaction();

        try{
            DB::transaction(function () use($request, $monthName, $employee, $payment, $cash, $account, $accTransaction){
                $payment->employee_id = $employee->id;
                $payment->year = $request->salary_year;
                $payment->month = $request->salary_month;
                $payment->date = Carbon::parse($request->salary_date)->format('Y-m-d');
                $payment->payment_type = $request->salary_payment_type;
                $payment->bank_account_id = $request->salary_account;
                $payment->salary = $request->salary;

                if($request->deduct_advance > 0)
                {
                    $payment->advance_deduct = $request->deduct_advance;
                    $employee->advance -= $request->deduct_advance;
                }
                
                if($request->salary_payment_type === 'cash' && $request->salary > 0)
                {
                    $cash->date = Carbon::parse($request->salary_date)->format('Y-m-d');
                    $cash->expense = $request->salary;
                                         
                    $cash->description = 'Given Salary for ' . $monthName . ', ' . $request->salary_year . ' to Employee: ' . $employee->name;
                                       
                    $cash->save();
                }
                else if($request->salary_payment_type === 'cheque' && $request->salary > 0)
                {
                    if($account->balance < $request->salary)
                    {
                        //message not showing in $e->getMessage(); No solution found. check later...
                        throw ValidationException::withMessages(['error' => "You don't have sufficient balance in your Bank Account !"]);
                    }
                    $account->balance -= $request->salary;
                    $account->save();
        
                    $accTransaction->bank_account_id = $account->id;
                    $accTransaction->transaction_date = Carbon::parse($request->salary_date)->format('Y-m-d');
                    $accTransaction->withdraw = $request->salary;
                    $accTransaction->balance = $account->balance;
                    
                    $accTransaction->description = 'Given Salary for ' . $monthName . ', ' . $request->salary_year . ' to Employee: ' . $employee->name;
                                                       
                    $accTransaction->save();
                }
                $employee->save();
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

        Toastr::success('Salary Payment Successfully Done !' ,'Success');

        return redirect()->route('admin.employee.index');
    }

    public function advance(Request $request, $id)
    {
        $this->validate($request,[
            'advance' => 'required|numeric',
            'advance_date' => 'required|date'
        ]);

        $employee = Employee::find($id);
        $cash = new Cash();
        $account = BankAccount::find($request->advance_account);
        $accTransaction = new BankAccountTransaction();

        try{
            DB::transaction(function () use($request, $employee, $cash, $account, $accTransaction){
                $employee->advance += $request->advance;
                $employee->advance_date = Carbon::parse($request->advance_date)->format('Y-m-d');
                
                if($request->advance_payment_type === 'cash')
                {
                    $cash->date = Carbon::parse($request->advance_date)->format('Y-m-d');
                    $cash->expense = $request->advance;
                                         
                    $cash->description = 'Given Advance Salary to Employee: ' . $employee->name;
                                       
                    $cash->save();
                }
                else
                {
                    if($account->balance < $request->advance)
                    {
                        //message not showing in $e->getMessage(); No solution found. check later...
                        throw ValidationException::withMessages(['error' => "You don't have sufficient balance in your Bank Account !"]);
                    }
                    $account->balance -= $request->advance;
                    $account->save();
        
                    $accTransaction->bank_account_id = $account->id;
                    $accTransaction->transaction_date = Carbon::parse($request->advance_date)->format('Y-m-d');
                    $accTransaction->withdraw = $request->advance;
                    $accTransaction->balance = $account->balance;
                    
                    $accTransaction->description = 'Given Advance Salary to Employee: ' . $employee->name;
                                                       
                    $accTransaction->save();
                }
                $employee->save();
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

        Toastr::success('Advance Payment Successfully Done !' ,'Success');

        return redirect()->route('admin.employee.index');
    }

    public function bonus(Request $request, $id)
    {
        $this->validate($request,[
            'bonus_year' => 'required|integer',
            'bonus_month' => 'required|integer',
            'bonus' => 'required|numeric',
            'bonus_date' => 'required|date'
        ]);

        /* get Month Name from Number */
        $monthNum  = $request->bonus_month;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F');
        /*...............................*/

        $employee = Employee::find($id);
        $payment = new EmployeePayment();
        $cash = new Cash();
        $account = BankAccount::find($request->bonus_account);
        $accTransaction = new BankAccountTransaction();

        try{
            DB::transaction(function () use($request, $monthName, $employee, $payment, $cash, $account, $accTransaction){
                $payment->employee_id = $employee->id;
                $payment->year = $request->bonus_year;
                $payment->month = $request->bonus_month;
                $payment->date = Carbon::parse($request->bonus_date)->format('Y-m-d');
                $payment->payment_type = $request->bonus_payment_type;
                $payment->bank_account_id = $request->bonus_account;
                $payment->bonus = $request->bonus;
                
                if($request->bonus_payment_type === 'cash')
                {
                    $cash->date = Carbon::parse($request->bonus_date)->format('Y-m-d');
                    $cash->expense = $request->bonus;
                                         
                    $cash->description = 'Given Bonus Salary for ' . $monthName . ', ' . $request->bonus_year . ' to Employee: ' . $employee->name;
                                       
                    $cash->save();
                }
                else
                {
                    if($account->balance < $request->bonus)
                    {
                        //message not showing in $e->getMessage(); No solution found. check later...
                        throw ValidationException::withMessages(['error' => "You don't have sufficient balance in your Bank Account !"]);
                    }
                    $account->balance -= $request->bonus;
                    $account->save();
        
                    $accTransaction->bank_account_id = $account->id;
                    $accTransaction->transaction_date = Carbon::parse($request->bonus_date)->format('Y-m-d');
                    $accTransaction->withdraw = $request->bonus;
                    $accTransaction->balance = $account->balance;
                    
                    $accTransaction->description = 'Given Bonus Salary for ' . $monthName . ', ' . $request->bonus_year . ' to Employee: ' . $employee->name;
                                                       
                    $accTransaction->save();
                }
                $employee->save();
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

        Toastr::success('Bonus Payment Successfully Done !' ,'Success');

        return redirect()->route('admin.employee.index');
    }
}
