@extends('layouts.backend.app')

@section('title', 'Bank')

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
                            TRANSACTIONS
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
                            <li role="presentation" class="">
                                <a href="#interest_tab" data-toggle="tab" aria-expanded="false">
                                    <i class="material-icons">info</i> INTEREST
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="deposite_tab">
                                <form action="{{route('admin.account.deposite', $account->id)}}" method="POST" 
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    @php
                                        $cash = $cash;
                                    @endphp
                                    <div class="row clearfix" style="margin-top: 30px;">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="new_balance_deposite">New A/C Balance</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="new_balance_deposite" name="new_balance_deposite" value="{{ round($account->balance, 2) }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="balance_deposite">A/C Balance</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="balance_deposite" name="balance_deposite" value="{{  round($account->balance, 2) }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="deposite">Deposite</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('deposite') ? 'focused error' : '' }}">
                                                    <input type="number" id="deposite" onkeyup="newBalanceDeposite()" onchange="newBalanceDeposite()" class="form-control @error('deposite') is-invalid @enderror" 
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
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                                            <div class="form-group">
                                                <input name="deposited_from" type="radio" id="from_cash" value="cash" onchange="newBalanceDeposite()" class="with-gap radio-col-pink radio" checked />
                                                    <label for="from_cash">FROM CASH</label>
                                                <input name="deposited_from" type="radio" id="from_personal" value="personal" onchange="newBalanceDeposite()" class="with-gap radio-col-pink radio" />
                                                    <label for="from_personal">PERSONAL</label>
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
                                            <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.account.index') }}">BACK</a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div role="tabpanel" class="tab-pane fade" id="withdraw_tab">
                                <form action="{{route('admin.account.withdraw', $account->id)}}" method="POST" 
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix" style="margin-top: 30px;">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="new_balance_withdraw">New A/C Balance</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="new_balance_withdraw" name="new_balance_withdraw" value="{{ round($account->balance, 2) }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="balance_withdraw">A/C Balance</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="balance_withdraw" name="balance_withdraw" value="{{  round($account->balance, 2) }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="withdraw">Withdraw</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('withdraw') ? 'focused error' : '' }}">
                                                    <input type="number" id="withdraw" onkeyup="newBalanceWithdraw()" onchange="newBalanceWithdraw()" class="form-control @error('withdraw') is-invalid @enderror" 
                                                        name="withdraw" min="0" step=".01" max="{{ $account->balance }}" value="{{ !empty(old('withdraw')) ? old('withdraw') : '' }}" required>                                                    
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
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                                            <div class="form-group">
                                                <input name="deposited_to" type="radio" id="to_cash" value="cash" class="with-gap radio-col-pink" checked />
                                                    <label for="to_cash">TO CASH</label>
                                                <input name="deposited_to" type="radio" id="to_personal" value="personal" class="with-gap radio-col-pink" />
                                                    <label for="to_personal">PERSONAL</label>
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
                                                    <textarea rows="2" class="form-control" id="description" name="description"
                                                        placeholder="Reason for withdrawal..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                 
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-4">
                                            <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.account.index') }}">BACK</a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="interest_tab">
                                <form action="{{route('admin.account.interest', $account->id)}}" method="POST" 
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix" style="margin-top: 30px;">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="new_balance_interest">New A/C Balance</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="new_balance_interest" name="new_balance_interest" value="{{ round($account->balance, 2) }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="balance_interest">A/C Balance</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="balance_interest" name="balance_interest" value="{{  round($account->balance, 2) }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="interest">Interest</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('interest') ? 'focused error' : '' }}">
                                                    <input type="number" id="interest" onkeyup="newBalanceInterest()" onchange="newBalanceInterest()" class="form-control @error('interest') is-invalid @enderror" 
                                                        name="interest" min="0" step=".01" value="{{ !empty(old('interest')) ? old('interest') : '' }}" required>                                                    
                                                </div>
                                                    @error('interest')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                            <label for="interest_date">Date</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="interest_date" name="interest_date" class="datepicker form-control" placeholder="Please choose a date..." required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                 
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-4">
                                            <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.account.index') }}">BACK</a>
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

<!-- Revice Balance after Deposite -->
    function newBalanceDeposite(){
        var deposite = parseFloat(document.getElementById('deposite').value);
        var balance = parseFloat(document.getElementById('balance_deposite').value);
        var newBalance = parseFloat(document.getElementById('new_balance_deposite').value);     
        
        /*if (document.getElementById('from_cash').checked) {
           radio = document.getElementById('from_cash').value;
        }else{
            radio = document.getElementById('from_personal').value;
        }*/
        var radio = $("input[type='radio'][name='deposited_from']:checked").val();

        //php variable $cash declared in top of deposite tab
        var cash = '<?php echo $cash;?>';

        if(radio == 'cash'){
            $('#deposite').attr({"max": cash});
            if(deposite > cash){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Insufficient Balance in Cash !',
                    footer: 'You have only '+ parseFloat(cash).toFixed(2) + ' Tk in your Cash.'
                  })
            }
        }
        else{
            $("#deposite").removeAttr("max");
        }        

        if(deposite){
            document.getElementById('new_balance_deposite').value = parseFloat(deposite + balance).toFixed(2);
        }
        else{
            document.getElementById('new_balance_deposite').value = balance;
        }
    };

<!-- Revice Balance after Withdraw -->
    function newBalanceWithdraw(){
        var withdraw = parseFloat(document.getElementById('withdraw').value);
        var balance = parseFloat(document.getElementById('balance_withdraw').value);
        var newBalance = parseFloat(document.getElementById('new_balance_withdraw').value);

        if(withdraw){
            document.getElementById('new_balance_withdraw').value = parseFloat(balance - withdraw).toFixed(2);
            if(document.getElementById('new_balance_withdraw').value < 0){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Insufficient Balance to Withdraw !',
                    footer: 'You have only '+ balance + ' Tk in your bank account.'
                  })
            }
            else{
                document.getElementById('new_balance_withdraw').value = parseFloat(balance - withdraw).toFixed(2);
            }
        }
        else{
            document.getElementById('new_balance_withdraw').value = balance;
        }
    };
    
<!-- Revice Balance after Interest -->
    function newBalanceInterest(){
        var interest = parseFloat(document.getElementById('interest').value);
        var balance = parseFloat(document.getElementById('balance_interest').value);
        var newBalance = parseFloat(document.getElementById('new_balance_interest').value);

        if(interest){
            document.getElementById('new_balance_interest').value = parseFloat(interest + balance).toFixed(2);
        }
        else{
            document.getElementById('new_balance_interest').value = balance;
        }
    };
</script>

@endpush