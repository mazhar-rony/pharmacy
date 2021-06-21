@extends('layouts.backend.app')

@section('title', 'Employee Salary')

@push('css')
<!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

<!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />

<!-- JQuery DataTable Css -->   
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">

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
    <div class="row clearfix">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="info-box bg-green hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">date_range</i>
                </div>
                <div class="content">
                    <div class="text">YEAR</div>
                    <div class="number">{{ $salaryYear }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="info-box bg-light-green hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">date_range</i>
                </div>
                <div class="content">
                    <div class="text">MONTH</div>
                    <div class="number">{{ $monthName }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Salary</th>
                                    <th>Salary Paid</th>
                                    <th>Advance Deduct</th>
                                    <th>Bonus</th>
                                    <th>Total Paid</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Salary</th>
                                    <th>Salary Paid</th>
                                    <th>Advance Deduct</th>
                                    <th>Bonus</th>
                                    <th>Total Paid</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($employees as $key=>$employee)
                                    <tr>                          
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $employee->employee->name }}</td>
                                        <td>{{ $employee->employee->designation }}</td>
                                        <td><span class="badge bg-indigo">{{ number_format(round($employee->employee->salary, 2), 2) }}</td>                   
                                        <td>{{ $employee->salary > 0 ? number_format(round($employee->salary, 2), 2) : '' }}</td>
                                        <td>{{ $employee->advance_deduct > 0 ? number_format(round($employee->advance_deduct, 2), 2) : '' }}</td>
                                        <td>{{ $employee->bonus > 0 ? number_format(round($employee->bonus, 2), 2) : '' }}</td>
                                        <td>{{ number_format(round($employee->salary + $employee->advance_deduct + $employee->bonus, 2), 2)}}</td>                                      
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>
    
<!-- Select Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

<!-- Autosize Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/autosize/autosize.js') }}"></script>

<!-- Moment Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/momentjs/moment.js') }}"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

<!-- Dependency Dropdown for Account No -->
    <script>    
        //$(function() {
        var loader_account = $('#loader_account'),
        bank = $('select[name="bank"]'),
        account = $('select[name="account"]');

        loader_account.hide();
        account.attr('disabled','disabled');

            $(document).on('change', '#bank', function(){
                var bank = $(this).val();
                if(bank){
                    loader_account.show();
                    account.attr('disabled','disabled');

                    $.ajax({
                        url: "{{route('admin.invoice.getBankAccounts')}}",
                        type: "GET",
                        data: {bank:bank},                   
                        success: function(data){
                            var option = '<option value="">Select Acount No</option>';
                            $.each(data, function(key,value){
                                option += '<option value="'+value.id+'">'+value.account_number+'</option>';
                            });
                            account.removeAttr('disabled');
                            $('#account').html(option);
                            //account.html(option);
                            loader_account.hide();
                            $(".selectpicker").selectpicker("refresh");
                        },
                        error: function(xhr, status, error) {
                            // check status && error
                            //console.log(error);
                        },
                    });
                }
            });

            account.change(function(){
                var id = $(this).val();
                if(!id){
                    account.attr('disabled','disabled');
                }
            })
                    
        //});
    </script>
@endpush