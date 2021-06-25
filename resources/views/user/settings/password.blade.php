@extends('layouts.backend.app')

@section('title', 'Change Password')

@push('css')

<!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />  

@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix" style="padding-top: 2%">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3">
            <div class="signup-box">
                <div class="card">
                    <div class="header bg-pink">
                        <h2 class="text-center">
                            CHANGE PASSWORD
                        </h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('user.password.update') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <label for="old_password">Old Password</label>
                                </span>
                                <div class="form-line {{ $errors->has('old_password') ? 'focused error' : '' }}">
                                    <input type="password" class="form-control @error('old_password') is-invalid @enderror" 
                                        id="old_password" name="old_password" value="{{ !empty(old('old_password')) ? old('old_password') : '' }}" 
                                        placeholder="Old Password" required autofocus>
                                </div>
                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <label for="password">New Password</label>
                                </span>
                                <div class="form-line {{ $errors->has('password') ? 'focused error' : '' }}">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                        id="password" name="password" value="{{ !empty(old('password')) ? old('password') : '' }}" 
                                        minlength="5" placeholder="New Password" required>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <label for="password_confirmation">New Password <br>(Confirm)</label>
                                </span>
                                <div class="form-line {{ $errors->has('password_confirmation') ? 'focused error' : '' }}">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                        id="password_confirmation" name="password_confirmation" minlength="5" placeholder="New Password (Confirm)" required>
                                </div>
                            </div>
            
                            <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">SUBMIT</button>
            
                        </form>
                    </div>
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

@endpush