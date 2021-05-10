@extends('layouts.backend.app')

@section('title', 'Office Expense')

@push('css')
<!-- Bootstrap Material Datetime Picker Css -->
<link href="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            OFFICE EXPENSE
                        </h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('admin.expense.store') }}" method="POST" 
                            class="form-horizontal">
                            @csrf   
                            @php
                                $cash = $cash;
                            @endphp 
                            <div class="row clearfix" style="margin-top: 30px;">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                    <label for="expense">Withdraw</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <div class="form-line {{ $errors->has('expense') ? 'focused error' : '' }}">
                                            <input type="number" id="expense" onkeyup="checkBalance()" onchange="checkBalance()" class="form-control @error('expense') is-invalid @enderror" 
                                                name="expense" min="0" max="{{ $cash }}" step=".01" value="{{ !empty(old('expense')) ? old('expense') : '' }}" required>                                                    
                                        </div>
                                            @error('expense')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong style="color: red">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                    <label for="date">Date</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="date" name="date" class="datepicker form-control" placeholder="Please choose a date..." required>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                    <label for="description">Description</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="2" class="form-control" id="description" name="description"
                                                required placeholder="Reason for withdrawal..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>                                 
                            <div class="row clearfix">
                                <div class="col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-4">
                                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
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
    
    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script type="text/javascript">

    <!-- Check Cash Flow -->
    function checkBalance(){
        var cash = '<?php echo $cash;?>';
        var expense = parseFloat(document.getElementById('expense').value);        

        if(expense > cash){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Insufficient Balance in Cash !',
                footer: 'You have only '+ parseFloat(cash).toFixed(2) + ' Tk in your Cash.'
              })
        }
    };

    
    </script>

@endpush