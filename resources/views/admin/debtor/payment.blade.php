@extends('layouts.backend.app')

@section('title', 'Debtor')

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
                            PAID BY DEBTOR
                        </h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('admin.debtor.paidByDebtor', $debtor->id) }}" method="POST" 
                            class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="row clearfix" style="margin-top: 30px;">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                    <label for="due_remain">Due Remain</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="due_remain" name="due_remain" value="{{ round($debtor->due, 2) }}" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                    <label for="due">Due</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="due" name="due" value="{{ round($debtor->due, 2) }}" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                                    <div class="form-group">
                                        <input name="payment_type" type="radio" id="cash" value="cash" onchange="dueRemain()" class="with-gap radio-col-pink radio" checked />
                                            <label for="cash">CASH</label>
                                        <input name="payment_type" type="radio" id="cheque" value="cheque" onchange="dueRemain()" class="with-gap radio-col-pink radio" />
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
                                    <label for="pay">Pay</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <div class="form-line {{ $errors->has('pay') ? 'focused error' : '' }}">
                                            <input type="number" id="pay" onkeyup="dueRemain()" onchange="dueRemain()" class="form-control @error('pay') is-invalid @enderror" 
                                                name="pay" min="0" step=".01" value="{{ !empty(old('pay')) ? old('pay') : '' }}" required>                                                    
                                        </div>
                                            @error('pay')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong style="color: red">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                            </div> 
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                    <label for="consession">Consession</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <div class="form-line {{ $errors->has('consession') ? 'focused error' : '' }}">
                                            <input type="number" id="consession" onkeyup="dueRemain()" onchange="dueRemain()" class="form-control @error('consession') is-invalid @enderror" 
                                                name="consession" min="0" step=".01" value="{{ !empty(old('consession')) ? old('consession') : 0 }}" required>                                                    
                                        </div>
                                            @error('consession')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong style="color: red">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                            </div> 
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                    <label for="payment_date">Date</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="payment_date" name="payment_date" class="datepicker form-control" placeholder="Please choose a date..." required>
                                        </div>
                                    </div>
                                </div>
                            </div>                                
                            <div class="row clearfix">
                                <div class="col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-4">
                                    <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.debtor.index') }}">BACK</a>
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

    <!-- Show Bank Info for Cheque Payment -->

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

    <!-- Dependency Dropdown for Account No -->

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
            

    <!-- Revice Due after Payment -->
    function dueRemain(){
        var pay = parseFloat(document.getElementById('pay').value);
        var consession = parseFloat(document.getElementById('consession').value);
        var due = parseFloat(document.getElementById('due').value);
        var due_remain = parseFloat(document.getElementById('due_remain').value);          

        if(pay || consession){
            document.getElementById('due_remain').value = parseFloat(due - (pay + consession)).toFixed(2);
            $('#consession').attr({"max": (due - pay)});//trying to restrict over payment
            $('#pay').attr({"max": (due - consession)});//trying to restrict over payment

            if(parseFloat(due - (pay + consession)) < 0){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Trying to pay more than due !',
                    footer: 'Your due amount is only '+ parseFloat(due).toFixed(2) + ' Tk'
                  })
            }
        }
        else{
            document.getElementById('due_remain').value = due;
        }
    };

    
    </script>

@endpush