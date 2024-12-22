<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
    </title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        .custom-toggler .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255,0,0, 1.0)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
        }

        .custom-toggler.navbar-toggler {
            border-color: rgb(255, 0, 0);
        }
    </style>
    @yield('style')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/print.css')}}">
</head>

<body>
    @csrf
    @yield('content')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sweetalerts2.min.js') }}"></script>
    <script src="{{ asset('js/choices.min.js') }}"></script>
    <script src="{{ asset('js/print.js') }}"></script>
</body>

</html>