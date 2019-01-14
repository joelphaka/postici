<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>
        @yield('pageTitle')
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="{{ url('/assets/js/jquery.js') }}"></script>
    @yield('styles')
</head>
<body>
<div id="mainContainer" class="container">
    @yield('content')
</div>
<script src="{{ url('/assets/js/bootstrap.js') }}"></script>
@yield('scripts')
</body>
</html>