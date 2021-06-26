@extends('layouts.backend.app')

@section('title', 'Bank')

@push('css')
<!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

<style>
    .loader {
        position: absolute;
        height: 80px;;
        right: 18px;
        bottom: 2px;
    }
</style>
    
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        EDIT ACCOUNT
                    </h2>
                </div>
                <div class="body">
                    <form action="{{ route('admin.account.update', $account->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('account_name') ? 'focused error' : '' }}">
                                <input type="text" id="account_name" class="form-control @error('account_name') is-invalid @enderror" 
                                    name="account_name" value="{{ !empty(old('account_name')) ? old('account_name') : $account->account_name }}">
                                <label class="form-label">Account Name</label>
                               
                            </div>
                            @error('account_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('account_number') ? 'focused error' : '' }}">
                                <input type="text" id="account_number" class="form-control @error('account_number') is-invalid @enderror" 
                                    name="account_number" value="{{ !empty(old('account_number')) ? old('account_number') : $account->account_number }}">
                                <label class="form-label">Account Number</label>
                               
                            </div>
                            @error('account_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('bank') ? 'focused error' : '' }}">
                                <label for="bank">Select Bank</label>
                                <select name="bank" id="bank" data-live-search="true" 
                                    class="form-control show-tick @error('bank') is-invalid @enderror">
                                    @foreach ($banks as $bank)
                                        <option {{ $account->bank_id == $bank->id ? 'selected' : '' }}
                                            value="{{ $bank->id }}">{{ $bank->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('bank')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('branch') ? 'focused error' : '' }}">
                                <label for="branch">Select Branch</label>
                                <img class="loader" id="loader" src="{{Storage::disk('public')->url('ajax-loader.gif')}}" alt="">
                                <select name="branch" id="branch" data-live-search="true" 
                                    class="form-control selectpicker show-tick @error('branch') is-invalid @enderror">
                                    @foreach ($branches as $branch)
                                        <option {{ $account->branch->id == $branch->id ? 'selected' : '' }}
                                            value="{{ $branch->id }}">{{ $branch->name }}
                                        </option>                                        
                                    @endforeach                                   
                                        {{-- <option value="{{ $account->branch->id }}">{{ $account->branch->name }}</option>                                                                   --}}
                                </select>
                                
                            </div>
                            @error('branch')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('type') ? 'focused error' : '' }}">
                                <label for="type">Account Type</label>
                                <select name="type" id="type" data-live-search="true" 
                                    class="form-control show-tick @error('type') is-invalid @enderror">              
                                        <option value="0" {{ $account->account_type == 'Current' ? 'selected' : '' }}>Current</option>
                                        <option value="1" {{ $account->account_type == 'Savings' ? 'selected' : '' }}>Savings</option>                                   
                                </select>
                            </div>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('balance') ? 'focused error' : '' }}">
                                <input type="number" id="balance" class="form-control @error('balance') is-invalid @enderror" 
                                    name="balance" min="0" step=".01" value="{{ !empty(old('balance')) ? old('balance') : round($account->balance, 2) }}" readonly>
                                <label class="form-label">Account Balance</label>
                               
                            </div>
                            @error('balance')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.account.index') }}">BACK</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
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

<!-- Dependency Dropdown for Bank Branches -->
    <script>
        //$(function(){
            var loader = $('#loader'),
                bank = $('select[name="bank"]'),
                branch = $('select[name="branch"]');

            loader.hide();
            //branch.attr('disabled','disabled');
            
            bank.change(function(){
                var id = $(this).val();
                if(id){
                    loader.show();
                    branch.attr('disabled','disabled');

                    $.get('{{url('/dependency/branches?bank=')}}'+id)
                        .success(function(data){
                            var option = '<option value="" selected disabled>Nothing Selected</option>';
                            data.forEach(function(row){
                                option += '<option value="'+row.id+'">'+row.name+'</option>'
                            })
                            branch.removeAttr('disabled');
                            branch.html(option);
                            loader.hide();
                            $(".selectpicker").selectpicker("refresh");
                        })
                }
            })

            branch.change(function(){
                var id = $(this).val();
                if(!id){
                    branch.attr('disabled','disabled');
                }
            })
        //});
    </script>

@endpush