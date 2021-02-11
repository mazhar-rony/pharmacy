<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Sign In</title>

    {{-- <!-- Favicon-->
    <link rel="icon" href="{{ asset('storage/favicon.ico') }}" type="image/x-icon">

    <!-- Font -->

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet"> --}}


	<!-- Stylesheets -->

	<!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('assets/backend/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('assets/backend/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('assets/backend/css/style.css') }}" rel="stylesheet">

</head>
<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Pacific <b>SURGICAL</b></a>
            <small>Health is Wealth – Keep this treasure Safe</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="msg">Sign in to start your session</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line {{ $errors->has('email') ? 'focused error' : '' }}">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>                   
                        </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color:#E91E63">{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line {{ $errors->has('password') ? 'focused error' : '' }}">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">                            
                        </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: #E91E63">{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink" {{ old('remember') ? 'checked' : '' }}>
                            <label for="rememberme">{{ __('Remember Me') }}</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">{{ __('SIGN IN') }}</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-12 align-right">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SCIPTS -->

    <!-- Jquery Core Js -->
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/node-waves/waves.js') }}"></script>

    <!-- Validation Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-validation/jquery.validate.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('assets/backend/js/admin.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/examples/sign-in.js') }}"></script>

</body>
</html>
