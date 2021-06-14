@extends('layouts.backend.app')

@section('title', 'Employee')

@push('css')
<!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

<!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />

    <style>
        .loader {
            position: absolute;
            height: 80px;;
            right: -80px;
            bottom: -30px;
        }
        input::-webkit-outer-spin-button, 
        input::-webkit-inner-spin-button { 
            margin-left: 5px; 
        } 
    </style>

@endpush

@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            PAYMENTS
                        </h2>
                    </div>
                    <div class="body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#salary_tab" data-toggle="tab" aria-expanded="false">
                                    <i class="material-icons">attach_money</i> SALARY
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#advance_tab" data-toggle="tab" aria-expanded="true">
                                    <i class="material-icons">upload</i> ADVANCE
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#bonus_tab" data-toggle="tab" aria-expanded="true">
                                    <i class="material-icons">card_giftcard</i> BONUS
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="salary_tab">
                                <form action="{{route('admin.employee.salary', $employee->id)}}" method="POST" 
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    @php
                                        $cash = $cash;
                                        $employee_id = $employee->id;
                                    @endphp
                                    <div class="row clearfix" style="margin-top: 30px;">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="employee_salary">Employee Salary</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line" style="background-color: #D8FDBA;">
                                                    <input type="number" id="employee_salary" name="employee_salary" value="{{ round($employee->salary, 2) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="employee_salary_paid">Salary Paid</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line" style="background-color: #D8FDBA;">
                                                    <input type="number" id="employee_salary_paid" name="employee_salary_paid" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="employee_salary_due">Salary Due</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line" style="background-color: #D8FDBA;">
                                                    <input type="number" id="employee_salary_due" name="employee_salary_due" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="salary_year">Salary of Year</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select name="salary_year" id="salary_year" data-live-search="true" 
                                                        class="form-control show-tick @error('salary_year') is-invalid @enderror" required>
                                                            <option value="" selected disabled>Nothing Selected</option>
                                                            @for ($year = date('Y'); $year > date('Y') - 100; $year--)
                                                                <option value="{{$year}}">
                                                                        {{$year}}
                                                                </option>
                                                            @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="salary_month">Salary of Month</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select name="salary_month" id="salary_month" data-live-search="true" 
                                                        class="form-control show-tick @error('salary_month') is-invalid @enderror" required>
                                                            <option value="" selected disabled>Nothing Selected</option>
                                                            @foreach(range(1,12) as $month)              
                                                                <option value="{{$month}}">
                                                                        {{--  {{date("M", strtotime('2016-'.$month))}}  --}}
                                                                        {{date("F", strtotime('2021-'.$month))}}
                                                                </option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="due_remain">Remaining Due</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line" style="background-color: #D8FDBA;">
                                                    <input type="number" id="due_remain" name="due_remain" min="0" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="salary">Pay Salary</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('salary') ? 'focused error' : '' }}">
                                                    <input type="number" id="salary" onkeyup="checkSalaryCash()" onchange="checkSalaryCash()" class="form-control @error('salary') is-invalid @enderror" 
                                                        name="salary" min="0" step=".01" value="{{ !empty(old('salary')) ? old('salary') : 0 }}" required>                                                    
                                                </div>
                                                    @error('salary')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="deduct_advance">Advance Deduct</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('deduct_advance') ? 'focused error' : '' }}">
                                                    <input type="number" id="deduct_advance" class="form-control @error('deduct_advance') is-invalid @enderror" 
                                                        name="deduct_advance" min="0" step=".01" value="{{ !empty(old('deduct_advance')) ? old('deduct_advance') : 0 }}" required
                                                        {{ $employee->advance > 0 ? '' : 'readonly' }}>                                                    
                                                </div>
                                                    @error('deduct_advance')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                                            <div class="form-group">
                                                <input name="salary_payment_type" type="radio" id="salary_cash" value="cash" onchange="checkSalaryCash()" class="with-gap radio-col-pink radio" checked />
                                                    <label for="salary_cash">FROM CASH</label>
                                                <input name="salary_payment_type" type="radio" id="salary_cheque" value="cheque" onchange="checkSalaryCash()" class="with-gap radio-col-pink radio" />
                                                    <label for="salary_cheque">BY CHEQUE</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="salary_bank_info" style="display:none">
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                                <label for="salary_bank">Bank</label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                                <div class="form-group">
                                                    <div class="form-line {{ $errors->has('salary_bank') ? 'focused error' : '' }}">
                                                        <select name="salary_bank" id="salary_bank" data-live-search="true" 
                                                            class="form-control show-tick @error('salary_bank') is-invalid @enderror">
                                                                <option value="" disabled selected>Select Bank</option>
                                                            @foreach ($banks as $bank)
                                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('salary_bank')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                                <label for="salary_account">Account No</label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                                <div class="form-group">
                                                    <div class="form-line {{ $errors->has('salary_account') ? 'focused error' : '' }}">
                                                        <img class="loader" id="loader_salary" src="{{Storage::disk('public')->url('ajax-loader.gif')}}" alt="">
                                                        <select name="salary_account" id="salary_account" data-live-search="true" 
                                                            class="form-control selectpicker show-tick @error('salary_account') is-invalid @enderror">
                                                                <option value="" disabled selected>Select Account No</option>
                                                        </select>
                                                    </div>
                                                    @error('salary_account')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="salary_date">Date</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="salary_date" name="salary_date" class="datepicker form-control" placeholder="Please choose a date..." required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-4">
                                            <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.employee.index') }}">BACK</a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div role="tabpanel" class="tab-pane fade" id="advance_tab">
                                <form action="{{route('admin.employee.advance', $employee->id)}}" method="POST" 
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix" style="margin-top: 30px;">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="advance">Advance Amount</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('advance') ? 'focused error' : '' }}">
                                                    <input type="number" id="advance" onkeyup="checkAdvanceCash()" onchange="checkAdvanceCash()" class="form-control @error('advance') is-invalid @enderror" 
                                                        name="advance" min="0" step=".01" value="{{ !empty(old('advance')) ? old('advance') : '' }}" required>                                                    
                                                </div>
                                                    @error('advance')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row clearfix">
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                                            <div class="form-group">
                                                <input name="advance_payment_type" type="radio" id="advance_cash" value="cash" onchange="checkAdvanceCash()" class="with-gap radio-col-pink radio" checked />
                                                    <label for="advance_cash">FROM CASH</label>
                                                <input name="advance_payment_type" type="radio" id="advance_cheque" value="cheque" onchange="checkAdvanceCash()" class="with-gap radio-col-pink radio" />
                                                    <label for="advance_cheque">BY CHEQUE</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="advance_bank_info" style="display:none">
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                                <label for="advance_bank">Bank</label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                                <div class="form-group">
                                                    <div class="form-line {{ $errors->has('advance_bank') ? 'focused error' : '' }}">
                                                        <select name="advance_bank" id="advance_bank" data-live-search="true" 
                                                            class="form-control show-tick @error('advance_bank') is-invalid @enderror">
                                                                <option value="" disabled selected>Select Bank</option>
                                                            @foreach ($banks as $bank)
                                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('advance_bank')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                                <label for="advance_account">Account No</label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                                <div class="form-group">
                                                    <div class="form-line {{ $errors->has('advance_account') ? 'focused error' : '' }}">
                                                        <img class="loader" id="loader_advance" src="{{Storage::disk('public')->url('ajax-loader.gif')}}" alt="">
                                                        <select name="advance_account" id="advance_account" data-live-search="true" 
                                                            class="form-control selectpicker show-tick @error('advance_account') is-invalid @enderror">
                                                                <option value="" disabled selected>Select Account No</option>
                                                        </select>
                                                    </div>
                                                    @error('advance_account')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="advance_date">Date</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="advance_date" name="advance_date" class="datepicker form-control" placeholder="Please choose a date..." required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-4">
                                            <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.employee.index') }}">BACK</a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                                        </div>
                                    </div> 
                                </form>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="bonus_tab">
                                <form action="{{route('admin.employee.bonus', $employee->id)}}" method="POST" 
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix" style="margin-top: 30px;">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="bonus_year">Bonus of Year</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select name="bonus_year" id="bonus_year" data-live-search="true" 
                                                        class="form-control show-tick @error('bonus_year') is-invalid @enderror" required>
                                                            <option value="" selected disabled>Nothing Selected</option>
                                                            @for ($year = date('Y'); $year > date('Y') - 100; $year--)
                                                                <option value="{{$year}}">
                                                                        {{$year}}
                                                                </option>
                                                            @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="bonus_month">Bonus of Month</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select name="bonus_month" id="bonus_month" data-live-search="true" 
                                                        class="form-control show-tick @error('bonus_month') is-invalid @enderror" required>
                                                            <option value="" selected disabled>Nothing Selected</option>
                                                            @foreach(range(1,12) as $month)              
                                                                <option value="{{$month}}">
                                                                        {{--  {{date("M", strtotime('2016-'.$month))}}  --}}
                                                                        {{date("F", strtotime('2021-'.$month))}}
                                                                </option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="bonus">Bonus Amount</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('bonus') ? 'focused error' : '' }}">
                                                    <input type="number" id="bonus" onkeyup="checkBonusCash()" onchange="checkBonusCash()" class="form-control @error('bonus') is-invalid @enderror" 
                                                        name="bonus" min="0" step=".01" value="{{ !empty(old('bonus')) ? old('bonus') : '' }}" required>                                                    
                                                </div>
                                                    @error('bonus')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                                            <div class="form-group">
                                                <input name="bonus_payment_type" type="radio" id="bonus_cash" value="cash" onchange="checkBonusCash()" class="with-gap radio-col-pink radio" checked />
                                                    <label for="bonus_cash">FROM CASH</label>
                                                <input name="bonus_payment_type" type="radio" id="bonus_cheque" value="cheque" onchange="checkBonusCash()" class="with-gap radio-col-pink radio" />
                                                    <label for="bonus_cheque">BY CHEQUE</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bonus_bank_info" style="display:none">
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                                <label for="bonus_bank">Bank</label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                                <div class="form-group">
                                                    <div class="form-line {{ $errors->has('bonus_bank') ? 'focused error' : '' }}">
                                                        <select name="bonus_bank" id="bonus_bank" data-live-search="true" 
                                                            class="form-control show-tick @error('bonus_bank') is-invalid @enderror">
                                                                <option value="" disabled selected>Select Bank</option>
                                                            @foreach ($banks as $bank)
                                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('bonus_bank')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                                <label for="bonus_account">Account No</label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                                <div class="form-group">
                                                    <div class="form-line {{ $errors->has('bonus_account') ? 'focused error' : '' }}">
                                                        <img class="loader" id="loader_bonus" src="{{Storage::disk('public')->url('ajax-loader.gif')}}" alt="">
                                                        <select name="bonus_account" id="bonus_account" data-live-search="true" 
                                                            class="form-control selectpicker show-tick @error('bonus_account') is-invalid @enderror">
                                                                <option value="" disabled selected>Select Account No</option>
                                                        </select>
                                                    </div>
                                                    @error('bonus_account')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="bonus_date">Date</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="bonus_date" name="bonus_date" class="datepicker form-control" placeholder="Please choose a date..." required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-4">
                                            <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.employee.index') }}">BACK</a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<!-- Select Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

<!-- Autosize Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/autosize/autosize.js') }}"></script>

<!-- Moment Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/momentjs/moment.js') }}"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    
    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
    <!-- Show Bank Info for Cheque Payment of Salary -->

        $(document).on('change', 'input[name=salary_payment_type]', function(){
            var salary_payment_type = $(this).val();
            if(salary_payment_type == 'cheque'){
                $('.salary_bank_info').show();
                $('#salary_bank').attr({"required": true});
                $('#salary_account').attr({"required": true});
            }else{
                $('.salary_bank_info').hide();
                $('#salary_bank').attr({"required": false});
                $('#salary_account').attr({"required": false});
            }
        });

    <!-- Dependency Dropdown for Account No of Salary -->

        var loader_salary = $('#loader_salary'),
        salary_bank = $('select[name="salary_bank"]'),
        salary_account = $('select[name="salary_account"]');

        loader_salary.hide();
        salary_account.attr('disabled','disabled');

            $(document).on('change', '#salary_bank', function(){
                var bank = $(this).val();
                if(bank){
                    loader_salary.show();
                    salary_account.attr('disabled','disabled');

                    $.ajax({
                        url: "{{route('admin.invoice.getBankAccounts')}}",
                        type: "GET",
                        data: {bank:bank},                   
                        success: function(data){
                            var option = '<option value="">Select Acount No</option>';
                            $.each(data, function(key,value){
                                option += '<option value="'+value.id+'">'+value.account_number+'</option>';
                            });
                            salary_account.removeAttr('disabled');
                            $('#salary_account').html(option);
                            //account.html(option);
                            loader_salary.hide();
                            $(".selectpicker").selectpicker("refresh");
                        },
                        error: function(xhr, status, error) {
                            // check status && error
                            //console.log(error);
                        },
                    });
                }
            });

            salary_account.change(function(){
                var id = $(this).val();
                if(!id){
                    salary_account.attr('disabled','disabled');
                }
            }) 

    <!-- Show Bank Info for Cheque Payment of Advance-->

        $(document).on('change', 'input[name=advance_payment_type]', function(){
            var advance_payment_type = $(this).val();
            if(advance_payment_type == 'cheque'){
                $('.advance_bank_info').show();
                $('#advance_bank').attr({"required": true});
                $('#advance_account').attr({"required": true});
            }else{
                $('.advance_bank_info').hide();
                $('#advance_bank').attr({"required": false});
                $('#advance_account').attr({"required": false});
            }
        });

    <!-- Dependency Dropdown for Account No of Advance -->

       var loader_advance = $('#loader_advance'),
       advance_bank = $('select[name="advance_bank"]'),
       advance_account = $('select[name="advance_account"]');

       loader_advance.hide();
       advance_account.attr('disabled','disabled');

            $(document).on('change', '#advance_bank', function(){
                var bank = $(this).val();
                if(bank){
                    loader_advance.show();
                    advance_account.attr('disabled','disabled');

                    $.ajax({
                        url: "{{route('admin.invoice.getBankAccounts')}}",
                        type: "GET",
                        data: {bank:bank},                   
                        success: function(data){
                            var option = '<option value="">Select Acount No</option>';
                            $.each(data, function(key,value){
                                option += '<option value="'+value.id+'">'+value.account_number+'</option>';
                            });
                            advance_account.removeAttr('disabled');
                            $('#advance_account').html(option);
                            //account.html(option);
                            loader_advance.hide();
                            $(".selectpicker").selectpicker("refresh");
                        },
                        error: function(xhr, status, error) {
                            // check status && error
                            //console.log(error);
                        },
                    });
                }
            });

            advance_account.change(function(){
                var id = $(this).val();
                if(!id){
                    advance_account.attr('disabled','disabled');
                }
            })

    <!-- Show Bank Info for Cheque Payment of Bonus-->

    $(document).on('change', 'input[name=bonus_payment_type]', function(){
        var bonus_payment_type = $(this).val();
        if(bonus_payment_type == 'cheque'){
            $('.bonus_bank_info').show();
            $('#bonus_bank').attr({"required": true});
            $('#bonus_account').attr({"required": true});
        }else{
            $('.bonus_bank_info').hide();
            $('#bonus_bank').attr({"required": false});
            $('#bonus_account').attr({"required": false});
        }
    });
    
    <!-- Dependency Dropdown for Account No of Advance -->

        var loader_bonus = $('#loader_bonus'),
        bonus_bank = $('select[name="bonus_bank"]'),
        bonus_account = $('select[name="bonus_account"]');

        loader_bonus.hide();
        bonus_account.attr('disabled','disabled');

            $(document).on('change', '#bonus_bank', function(){
                var bank = $(this).val();
                if(bank){
                    loader_bonus.show();
                    bonus_account.attr('disabled','disabled');

                    $.ajax({
                        url: "{{route('admin.invoice.getBankAccounts')}}",
                        type: "GET",
                        data: {bank:bank},                   
                        success: function(data){
                            var option = '<option value="">Select Acount No</option>';
                            $.each(data, function(key,value){
                                option += '<option value="'+value.id+'">'+value.account_number+'</option>';
                            });
                            bonus_account.removeAttr('disabled');
                            $('#bonus_account').html(option);
                            //account.html(option);
                            loader_bonus.hide();
                            $(".selectpicker").selectpicker("refresh");
                        },
                        error: function(xhr, status, error) {
                            // check status && error
                            //console.log(error);
                        },
                    });
                }
            });

            bonus_account.change(function(){
                var id = $(this).val();
                if(!id){
                    bonus_account.attr('disabled','disabled');
                }
            })

    <!-- Check Cash Balance for Advance Payment -->
        
    function checkAdvanceCash(){
        var advance = parseFloat(document.getElementById('advance').value);
        var radio_advance= $("input[type='radio'][name='advance_payment_type']:checked").val();

        var cash_advance = '<?php echo $cash;?>';
    
        if(radio_advance == 'cash'){
            $('#advance').attr({"max": cash_advance});
            if(advance > cash_advance){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Insufficient Balance in Cash !',
                    footer: 'You have only '+ parseFloat(cash_advance).toFixed(2) + ' Tk in your Cash.'
                  })
            }
        }
        else{
            $('#advance').removeAttr("max");
        }
    }

    <!-- Check Cash Balance for Bonus Payment -->
        
    function checkBonusCash(){
        var bonus = parseFloat(document.getElementById('bonus').value);
        var radio_bonus= $("input[type='radio'][name='bonus_payment_type']:checked").val();

        var cash_bonus = '<?php echo $cash;?>';
    
        if(radio_bonus == 'cash'){
            $('#bonus').attr({"max": cash_bonus});
            if(bonus > cash_bonus){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Insufficient Balance in Cash !',
                    footer: 'You have only '+ parseFloat(cash_bonus).toFixed(2) + ' Tk in your Cash.'
                  })
            }
        }
        else{
            $('#bonus').removeAttr("max");
        }
    }

    <!-- Check Cash Balance for Salary Payment -->
        
    function checkSalaryCash(){
        var salary = parseFloat(document.getElementById('salary').value);
        var radio_salary= $("input[type='radio'][name='salary_payment_type']:checked").val();

        var cash_salary = '<?php echo $cash;?>';
    
        if(radio_salary == 'cash'){
            $('#salary').attr({"max": cash_salary});
            if(salary > cash_salary){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Insufficient Balance in Cash !',
                    footer: 'You have only '+ parseFloat(cash_salary).toFixed(2) + ' Tk in your Cash.'
                  })
            }
        }
        else{
            $('#salary').removeAttr("max");
        }
    }

    <!-- Dependency Paid Salary with Selected Year -->
    
    $(document).on('change', '#salary_year', function(){
        var salary_year = $(this).val();
        var salary_month = $('#salary_month').val();
        var employee_id = '<?php echo $employee_id;?>';
        if(salary_year){                   
            $.ajax({
                url: "{{route('admin.invoice.getEmployeeSalary')}}",
                type: "GET",
                data: {salary_year:salary_year, salary_month:salary_month, employee_id:employee_id},                   
                success: function(data){
                    $('#employee_salary_paid').val(data);
                    $('#employee_salary_paid').trigger('change');
                },
                error: function(xhr, status, error) {
                    // check status && error
                    //console.log(error);
                },
            });
        }
    });

    <!-- Dependency Paid Salary with Selected Month -->
    
    $(document).on('change', '#salary_month', function(){
        var salary_month = $(this).val();
        var salary_year = $('#salary_year').val();
        var employee_id = '<?php echo $employee_id;?>';
        if(salary_month){                   
            $.ajax({
                url: "{{route('admin.invoice.getEmployeeSalary')}}",
                type: "GET",
                data: {salary_year:salary_year, salary_month:salary_month, employee_id:employee_id},                   
                success: function(data){
                    $('#employee_salary_paid').val(data);
                    $('#employee_salary_paid').trigger('change');
                },
                error: function(xhr, status, error) {
                    // check status && error
                    //console.log(error);
                },
            });
        }
    });

    <!-- Calculate Due Salary by Selecting Year & Month -->
    
    $(document).on('change', '#employee_salary_paid', function(){
        
        var employee_salary_paid = $(this).val();
        var employee_salary = $('#employee_salary').val();
        
        
        if(employee_salary_paid){                   
            $('#employee_salary_due').val(employee_salary - employee_salary_paid);
        }
    });

    <!-- Calculate Due Salary after Salary Payment -->
    
    $(document).on('keyup change', '#salary', function(){
        
        var salary = parseFloat($(this).val());
        var deduct_advance = parseFloat($('#deduct_advance').val());
        var employee_salary_due = parseFloat($('#employee_salary_due').val());
        
        $('#due_remain').val(employee_salary_due - (salary + deduct_advance));  
    });

    <!-- Calculate Due Salary after Advance Deduct -->
    
    $(document).on('keyup change', '#deduct_advance', function(){
        
        var deduct_advance = parseFloat($(this).val());
        var salary = parseFloat($('#salary').val());
        var employee_salary_due = parseFloat($('#employee_salary_due').val());
        
        $('#due_remain').val(parseFloat(employee_salary_due - (salary + deduct_advance)));
    });

    </script>

@endpush