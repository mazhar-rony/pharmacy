@extends('layouts.backend.app')

@section('title', 'Proprietor Expenses')

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
                        PROPRIETOR EXPENSES REPORT
                    </h2>
                </div>
                <div>
                    <form action="{{ route('admin.report.showProprietorExpenses') }}" method="POST">
                    @csrf
                        <div class="row clearfix" style="margin-top: 50px;">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label">
                                <label for="proprietor">Proprietor Name:</label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="proprietor" id="proprietor" data-live-search="true" 
                                            class="form-control show-tick @error('proprietor') is-invalid @enderror" required>
                                        <option value="" selected disabled>Nothing Selected</option>
                                            @foreach ($proprietors as $proprietor)
                                                <option value="{{ $proprietor->id }}">{{ $proprietor->name  }} ( {{ $proprietor->designation }} )</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label">
                                <label for="start_date">Start Date:</label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-8 col-xs-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="start_date" name="start_date" class="datepicker form-control" placeholder="Please choose a date..." required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label">
                                <label for="end_date">End Date:</label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-8 col-xs-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="end_date" name="end_date" class="datepicker form-control" placeholder="Please choose a date..." required>
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