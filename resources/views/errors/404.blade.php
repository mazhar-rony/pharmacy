<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>404 | Page Not Found</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('assets/backend/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('assets/backend/css/style.css') }}" rel="stylesheet">
</head>

<body class="four-zero-four">
    <div class="four-zero-four-container">
        <div class="error-code">404</div>
        <div class="error-message">This page doesn&#39;t exist</div>
        <div class="button-place">   
            {{-- <a href="{{ Auth::user()->role->id == 2 ? route('user.dashboard') : route('admin.dashboard') }}" class="btn btn-default btn-lg waves-effect">GO TO HOMEPAGE</a>          --}}
            {{-- <a href="/" class="btn btn-default btn-lg waves-effect">GO TO HOMEPAGE</a> --}}
            <a href="javascript:history.back()" class="btn btn-default btn-lg waves-effect"><i class="fas fa-hand-point-left"></i> GO BACK</a>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
    
    <!-- Bootstrap Core Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/node-waves/waves.js') }}"></script>
</body>

</html>