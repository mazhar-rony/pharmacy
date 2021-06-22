@extends('layouts.backend.app')

@section('title', 'User')

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
                            REGISTER A NEW USER
                        </h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('admin.user.store') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line {{ $errors->has('name') ? 'focused error' : '' }}">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ !empty(old('name')) ? old('name') : '' }}" 
                                        placeholder="Name Surname" required autofocus>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-line {{ $errors->has('email') ? 'focused error' : '' }}">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ !empty(old('email')) ? old('email') : '' }}" 
                                        placeholder="Email Address" required>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">manage_accounts</i>
                                </span>                                
                                    <select name="role" id="role" data-live-search="true" 
                                        class="form-control show-tick @error('role') is-invalid @enderror" required>
                                            <option value="" disabled selected>Select User Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>                               
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock</i>
                                </span>
                                <div class="form-line {{ $errors->has('password') ? 'focused error' : '' }}">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                        id="password" name="password" minlength="5" placeholder="Password" required>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock</i>
                                </span>
                                <div class="form-line {{ $errors->has('password_confirmation') ? 'focused error' : '' }}">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                        id="password_confirmation" name="password_confirmation" minlength="5" placeholder="Confirm Password" required>
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