<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') </title>
    <link href="{{ asset('css/materialdesignicons.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/saruma.css') }}">
</head>
<body class="s-bg-lnr-gradient--primary">
<div id="app" class="s-grid-login">
    <div class="s-card login-card">
        <div class="s-row h-100 no-wrap">
            <div class="s-col-desk-7">
                <div class="s-card__media">
                    <div class="s-image">
                        <img src="{{ asset('images/login-image.jpg') }}" alt="Tetra">
                    </div>
                </div>
            </div>
            <div class="s-col-desk-5">
                <div class="s-card__content grid-type-1">
                    <header class="s-card__header">
                        <h1 class="text-title text--primary">Tetra</h1>
                        <h3 class="text-subtitle">Class management system for colleges</h3>
                    </header>
                    <login-form-cards></login-form-cards>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
