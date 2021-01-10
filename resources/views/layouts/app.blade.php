<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}" />--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/DataTables-1.10.16/css/jquery.dataTables.min.css') }}" />
    {{--<link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">--}}
</head>
<body>
    @include('layouts.nav')
    @yield('content')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    {{--<script src="{{ asset('js/jquery.min.js') }}"></script>--}}
    {{--<script src="{{ asset('js/bootstrap.min.js') }}"></script>--}}

    @yield('script')
</body>
</html>
