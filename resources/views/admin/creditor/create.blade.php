@extends('layouts.backend.app')

@section('title', 'Creditor')

@push('css')
<!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

<!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ADD NEW CREDITOR
                    </h2>
                </div>
                <div class="body">
                    <form action="{{ route('admin.creditor.store') }}" method="POST">
                        @csrf
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('customer') ? 'focused error' : '' }}">
                                <label for="customer">Select Creditor Name</label>
                                <select name="customer" id="customer" data-live-search="true" 
                                    class="form-control show-tick @error('customer') is-invalid @enderror" required>
                                        <option value="" selected disabled>Nothing Selected</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} ( company: {{ $customer->organization }} | contact: {{ $customer->phone }} )</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('customer')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('amount') ? 'focused error' : '' }}">
                                <input type="number" id="amount" class="form-control @error('amount') is-invalid @enderror" 
                                    name="amount" min="0" step=".01" value="{{ !empty(old('amount')) ? old('amount') : '' }}" required>
                                <label class="form-label">Amount</label>
                            </div>
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="credit_date" name="credit_date" class="datepicker form-control" placeholder="Please choose a date..." required>
                            </div>
                        </div>  
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('description') ? 'focused error' : '' }}">
                                <textarea rows="2" class="form-control no-resize @error('description') is-invalid @enderror" 
                                    name="description">{{ !empty(old('description')) ? old('description') : '' }}</textarea>
                                <label class="form-label">Description</label>                               
                            </div>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.creditor.index') }}">BACK</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Vertical Layout | With Floating Label -->
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