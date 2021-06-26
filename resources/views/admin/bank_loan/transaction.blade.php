@extends('layouts.backend.app')

@section('title', 'Bank Loan')

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
                            TRANSACTIONS
                        </h2>
                    </div>
                    <div class="body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#emi_tab" data-toggle="tab" aria-expanded="false">
                                    <i class="material-icons">get_app</i> PAY EMI
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#closing_tab" data-toggle="tab" aria-expanded="true">
                                    <i class="material-icons">highlight_off</i> CLOSE LOAN
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="emi_tab">
                                <form id="payEmiForm" action="{{route('admin.loan.emi', $account->id)}}" method="POST" 
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    @php
                                        $cash = $cash;
                                    @endphp
                                    <div class="row clearfix" style="margin-top: 30px;">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="emi_no">EMI No</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line" style="background-color: #D8FDBA;">
                                                    <input type="text" id="emi_no" name="emi_no" value="{{ $account->emi_given + 1 }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="emi">EMI</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line" style="background-color: #D8FDBA;">
                                                    <input type="text" id="emi" name="emi" value="{{  round($account->emi_amount, 2) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                                            <div class="form-group">
                                                <input name="payment_type" type="radio" id="cash" value="cash" class="with-gap radio-col-pink radio" checked />
                                                    <label for="cash">CASH</label>
                                                <input name="payment_type" type="radio" id="cheque" value="cheque" class="with-gap radio-col-pink radio" />
                                                    <label for="cheque">CHEQUE</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bank_info" style="display:none">
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                                <label for="bank">Bank</label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                                <div class="form-group">
                                                    <div class="form-line {{ $errors->has('bank') ? 'focused error' : '' }}">
                                                        <select name="bank" id="bank" data-live-search="true" 
                                                            class="form-control show-tick @error('bank') is-invalid @enderror">
                                                                <option value="" disabled selected>Select Bank</option>
                                                            @foreach ($banks as $bank)
                                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('bank')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                                <label for="account">Account No</label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                                <div class="form-group">
                                                    <div class="form-line {{ $errors->has('account') ? 'focused error' : '' }}">
                                                        <img class="loader" id="loader_account" src="{{Storage::disk('public')->url('ajax-loader.gif')}}" alt="">
                                                        <select name="account" id="account" data-live-search="true" 
                                                            class="form-control selectpicker show-tick @error('account') is-invalid @enderror">
                                                                <option value="" disabled selected>Select Account No</option>
                                                        </select>
                                                    </div>
                                                    @error('account')
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
                                            <label for="emi_date">Date</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('emi_date') ? 'focused error' : '' }}">
                                                    <input type="text" id="emi_date" name="emi_date" class="datepicker form-control" value="{{ !empty(old('emi_date')) ? old('emi_date') : '' }}" placeholder="Please choose a date..." required>
                                                </div>
                                                @error('emi_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong style="color: red">{{ $message }}</strong>
                                                    </span>
                                                @enderror 
                                            </div>
                                        </div>                                                                            
                                    </div>     
                                                                
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-4">
                                            <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.loan.index') }}">BACK</a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect" onclick="payEMI()">SUBMIT</button>
                                            {{--  <button id="btnSubmit" class="btn btn-primary m-t-15 waves-effect" type="button" onclick="payEMI()">SUBMIT</button>  --}}
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div role="tabpanel" class="tab-pane fade" id="closing_tab">
                                <form id="cloaseLoanForm" action="{{route('admin.loan.close', $account->id)}}" method="POST" 
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    @php
                                        $cash = $cash;
                                    @endphp
                                    <div class="row clearfix" style="margin-top: 30px;">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="closing_amount">Closing Amount</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" id="closing_amount" onkeyup="dueRemain()" onchange="dueRemain()" class="form-control @error('closing_amount') is-invalid @enderror" 
                                                        name="closing_amount" min="0" step=".01" value="{{ !empty(old('closing_amount')) ? old('closing_amount') : '' }}" required>
                                                </div>
                                                @error('closing_amount')
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
                                                <input name="closing_payment_type" type="radio" id="closing_cash" value="cash" class="with-gap radio-col-pink radio" checked />
                                                    <label for="closing_cash">CASH</label>
                                                <input name="closing_payment_type" type="radio" id="closing_cheque" value="cheque" class="with-gap radio-col-pink radio" />
                                                    <label for="closing_cheque">CHEQUE</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="closing_bank_info" style="display:none">
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                                <label for="closing_bank">Bank</label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                                <div class="form-group">
                                                    <div class="form-line {{ $errors->has('closing_bank') ? 'focused error' : '' }}">
                                                        <select name="closing_bank" id="closing_bank" data-live-search="true" 
                                                            class="form-control show-tick @error('closing_bank') is-invalid @enderror">
                                                                <option value="" disabled selected>Select Bank</option>
                                                            @foreach ($banks as $bank)
                                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('closing_bank')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                                <label for="closing_account">Account No</label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                                <div class="form-group">
                                                    <div class="form-line {{ $errors->has('closing_account') ? 'focused error' : '' }}">
                                                        <img class="loader" id="loader_closing_account" src="{{Storage::disk('public')->url('ajax-loader.gif')}}" alt="">
                                                        <select name="closing_account" id="closing_account" data-live-search="true" 
                                                            class="form-control selectpicker show-tick @error('closing_account') is-invalid @enderror">
                                                                <option value="" disabled selected>Select Account No</option>
                                                        </select>
                                                    </div>
                                                    @error('closing_account')
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
                                            <label for="closing_emi_date">Date</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('closing_emi_date') ? 'focused error' : '' }}">
                                                    <input type="text" id="closing_emi_date" name="closing_emi_date" class="datepicker form-control" value="{{ !empty(old('closing_emi_date')) ? old('closing_emi_date') : '' }}" placeholder="Please choose a date..." required>
                                                </div>
                                                @error('closing_emi_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong style="color: red">{{ $message }}</strong>
                                                    </span>
                                                @enderror 
                                            </div>
                                        </div>                                                                            
                                    </div>     
                                                                
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-4">
                                            <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.loan.index') }}">BACK</a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect" onclick="closeLoan()">SUBMIT</button>
                                            {{--  <button id="btnSubmit" class="btn btn-primary m-t-15 waves-effect" type="button" onclick="payEMI()">SUBMIT</button>  --}}
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

<script type="text/javascript">

    <!-- Show Bank Info for Cheque Payment for EMI -->

        $(document).on('change', 'input[name=payment_type]', function(){
            var payment_type = $(this).val();
            if(payment_type == 'cheque'){
                $('.bank_info').show();
                $('#bank').attr({"required": true});
                $('#account').attr({"required": true});
            }else{
                $('.bank_info').hide();
                $('#bank').attr({"required": false});
                $('#account').attr({"required": false});
            }
        });

    <!-- Dependency Dropdown for Account No of EMI -->

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
                        url: "{{route('dependency.getBankAccounts')}}",
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

    <!-- Pay EMI of Loan -->

    function payEMI(){
        event.preventDefault();

        var cash = '<?php echo $cash;?>';
        var emi = parseFloat(document.getElementById('emi').value);
        var radio = $("input[type='radio'][name='payment_type']:checked").val();

        if(radio == 'cash'){
            if(emi > cash){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Insufficient Balance in Cash !',
                    footer: 'You have only '+ parseFloat(cash).toFixed(2) + ' Tk in your Cash.'
                  })
            }
            else{
                document.getElementById('payEmiForm').submit();
            }
        }
        else{
            document.getElementById('payEmiForm').submit();
        }

    };

    <!-- Show Bank Info for Cheque Payment of Close Loan -->

        $(document).on('change', 'input[name=closing_payment_type]', function(){
            var closing_payment_type = $(this).val();
            if(closing_payment_type == 'cheque'){
                $('.closing_bank_info').show();
                $('#closing_bank').attr({"required": true});
                $('#closing_account').attr({"required": true});
            }else{
                $('.closing_bank_info').hide();
                $('#closing_bank').attr({"required": false});
                $('#closing_account').attr({"required": false});
            }
        });

        <!-- Dependency Dropdown for Account No of Close Loan -->

        var loader_account = $('#loader_closing_account'),
        closing_bank = $('select[name="closing_bank"]'),
        closing_account = $('select[name="closing_account"]');

        loader_account.hide();
        closing_account.attr('disabled','disabled');

            $(document).on('change', '#closing_bank', function(){
                var closing_bank = $(this).val();
                if(closing_bank){
                    loader_account.show();
                    account.attr('disabled','disabled');

                    $.ajax({
                        url: "{{route('dependency.getBankAccounts')}}",
                        type: "GET",
                        data: {bank:closing_bank},                   
                        success: function(data){
                            var option = '<option value="">Select Acount No</option>';
                            $.each(data, function(key,value){
                                option += '<option value="'+value.id+'">'+value.account_number+'</option>';
                            });
                            closing_account.removeAttr('disabled');
                            $('#closing_account').html(option);
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
                    closing_account.attr('disabled','disabled');
                }
            })

    <!-- Close Loan -->
    function closeLoan(){
        event.preventDefault();

        var cash = '<?php echo $cash;?>';
        var closing_amount = parseFloat(document.getElementById('closing_amount').value);
        var radio = $("input[type='radio'][name='closing_payment_type']:checked").val();

        if(radio == 'cash'){
            if(closing_amount > cash){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Insufficient Balance in Cash !',
                    footer: 'You have only '+ parseFloat(cash).toFixed(2) + ' Tk in your Cash.'
                  })
            }
            else{
                document.getElementById('cloaseLoanForm').submit();
            }
        }
        else{
            document.getElementById('cloaseLoanForm').submit();
        }

    };
</script>

@endpush