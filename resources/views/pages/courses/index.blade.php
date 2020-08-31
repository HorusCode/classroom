@extends('layouts.app')
@section('title', 'Курсы')
@section('content')
    <header class="s-content__header">
        <h1 class="s-text--title">@yield('title')</h1>
    </header>
    <div class="s-content__body">
        <courses></courses>
    </div>
@endsection
