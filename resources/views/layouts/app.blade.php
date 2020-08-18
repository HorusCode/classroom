<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') </title>
    <link href="{{ asset('css/materialdesignicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/saruma.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="s-grid-main">
    <!--Header-->
    @include('includes.header')
    <!--Endheader-->
    <!--Sidebar-->
    @include('includes.sidebar')
    <!--EndSidebar-->
    <!--Content-->
    <main class="s-content">
        @yield('content')
    </main>
    <!--EndContent-->
    <!--Footer-->
    @include('includes.footer')
    <!--EndFooter-->
</div>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
