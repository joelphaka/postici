<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('pageTitle')</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ url('/assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/jquery-ui/jquery-ui.structure.min.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/jquery-ui/jquery-ui.theme.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ url('/assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/styles.css') }}" rel="stylesheet">
    @yield('styles')

    <!-- Custom Fonts -->
    <link href="{{ url('/assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="{{ url('/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('/assets/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>


@include('templates.partials.nav')
<div class="container-fluid relative" id="mainContainer">
    @yield('content')
</div>
@include('templates.partials.footer')
@yield('modals')
<!-- Bootstrap Core JavaScript -->
<script src="{{ url('/assets/js/bootstrap.min.js') }}"></script>
@include('templates.partials.api-search')
<script src="{{ url('/assets/js/script.js') }}"></script>
@yield('scripts')
</body>

</html>
