@extends('layouts.backend.app')

@section('title', 'Sales Details')

@push('css')

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
                        SALES DETAILS REPORT
                    </h2>
                </div>
                <div>
                    <form action="{{ route('admin.report.showSalesDetails') }}" method="POST">
                    @csrf
                        <div class="row clearfix" style="margin-top: 50px;">
                            <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">
                                <div class="form-group">
                                    <input type="checkbox" id="current_date" value="current" class="chk-col-pink form-control" checked />
                                    <label for="current_date">CURRENT DATE</label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">
                                <div class="form-group">
                                    <input type="checkbox" id="specific_date" value="specific" class="chk-col-pink form-control"/>
                                    <label for="specific_date">SPECIFIC DATE</label>
                                </div>
                            </div>
                            <div id="dateField" style="display:none" class="col-lg-3 col-md-3 col-sm-10 col-xs-10 col-sm-offset-1 col-xs-offset-1">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="date" name="date" class="datepicker form-control" placeholder="Please choose a date...">
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

<!-- Autosize Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/autosize/autosize.js') }}"></script>

<!-- Moment Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/momentjs/moment.js') }}"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    
    <script>
<!-- Show Date Field for Specific Date-->

        $('#current_date').on('click', function(){
            if ($(this).prop('checked')){
                $('#dateField').hide();
                $('#date').prop('required', false);
                $('#specific_date').prop('checked', false); 
            } 
            else{
                $('#dateField').show();
                $('#date').prop('required', true);
                $('#specific_date').prop('checked', true);
            } 
        });

        $('#specific_date').on('click', function(){
            if ($(this).prop('checked')){
                $('#dateField').show();
                $('#date').prop('required', true);
                $('#current_date').prop('checked', false); 
            } 
            else{
                $('#dateField').hide();
                $('#date').prop('required', false);
                $('#current_date').prop('checked', true);
            } 
        });
    </script>
@endpush