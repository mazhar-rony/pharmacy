@extends('layouts.backend.app')

@section('title', 'Proprietor')

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
                            PROPRIETOR TRANSACTIONS
                        </h2>
                    </div>
                    <div class="body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#deposite_tab" data-toggle="tab" aria-expanded="false">
                                    <i class="material-icons">get_app</i> DEPOSITE
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#withdraw_tab" data-toggle="tab" aria-expanded="true">
                                    <i class="material-icons">upload</i> WITHDRAW
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="deposite_tab">
                                <form action="{{route('admin.proprietor.deposite', $proprietor->id)}}" method="POST" 
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix" style="margin-top: 30px;">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="deposite">Deposite</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('deposite') ? 'focused error' : '' }}">
                                                    <input type="number" id="deposite" class="form-control @error('deposite') is-invalid @enderror" 
                                                        name="deposite" min="0" step=".01" value="{{ !empty(old('deposite')) ? old('deposite') : '' }}" required>                                                    
                                                </div>
                                                    @error('deposite')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="deposite_date">Date</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="deposite_date" name="deposite_date" class="datepicker form-control" placeholder="Please choose a date..." required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-4">
                                            <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.proprietor.index') }}">BACK</a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div role="tabpanel" class="tab-pane fade" id="withdraw_tab">
                                <form action="{{route('admin.proprietor.withdraw', $proprietor->id)}}" method="POST" 
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    @php
                                        $cash = $cash;
                                    @endphp
                                    <div class="row clearfix" style="margin-top: 30px;">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="withdraw">Withdraw</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('withdraw') ? 'focused error' : '' }}">
                                                    <input type="number" id="withdraw" onkeyup="checkBalance()" onchange="checkBalance()" class="form-control @error('withdraw') is-invalid @enderror" 
                                                        name="withdraw" min="0" step=".01" max="{{ $cash }}" value="{{ !empty(old('withdraw')) ? old('withdraw') : '' }}" required>                                                    
                                                </div>
                                                    @error('withdraw')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="withdraw_date">Date</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="withdraw_date" name="withdraw_date" class="datepicker form-control" placeholder="Please choose a date..." required>
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
                                                    <textarea rows="2" class="form-control" id="description" name="description" required
                                                        placeholder="Reason for withdrawal..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                 
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-4">
                                            <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.proprietor.index') }}">BACK</a>
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


<!-- Autosize Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/autosize/autosize.js') }}"></script>

<!-- Moment Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/momentjs/moment.js') }}"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    
    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script type="text/javascript">

    <!-- Check Cash Flow for Withdraw -->
    function checkBalance(){
        var cash = '<?php echo $cash;?>';
        var withdraw = parseFloat(document.getElementById('withdraw').value);

        if(withdraw > cash){
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