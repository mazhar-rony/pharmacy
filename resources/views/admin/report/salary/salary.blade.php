@extends('layouts.backend.app')

@section('title', 'Employee Salary')

@push('css')
<!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

<!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />

@endpush

@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-pink">
                    <h2 class="text-center">
                        EMPLOYEE SALARY REPORT
                    </h2>
                </div>
                <div>
                    <form action="{{ route('admin.report.showEmployeeSalary') }}" method="POST">
                    @csrf
                        <div class="row clearfix" style="margin-top: 50px;">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label">
                                <label for="year">Salary of Year:</label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-8 col-xs-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="year" id="year" data-live-search="true" 
                                            class="form-control show-tick @error('year') is-invalid @enderror" required>
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
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label">
                                <label for="month">Salary of Month</label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-8 col-xs-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="month" id="month" data-live-search="true" 
                                            class="form-control show-tick @error('month') is-invalid @enderror" required>
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
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-sm-offset-1 col-xs-offset-1">
                                <div class="form-group">
                                    <div class="form-line">
                                        <button type="submit" class="form-control btn bg-indigo waves-effect">
                                            <i class="material-icons">visibility</i>
                                            <span>SHOW</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>                                           
                    </form>
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

@endpush