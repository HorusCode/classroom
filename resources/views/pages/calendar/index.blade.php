@extends('layouts.app')
@section('title', 'Календарь событий')
@section('content')
    <header class="s-content__header">
        <h1 class="s-text--title">@yield('title')</h1>
    </header>
    <div class="s-content__body">
        {{-- TODO: Доделать события. Продумать добавление вручную.
                   Возможно, будет добавление автоматом при создании всякой херни  --}}
        <calendar></calendar>
    </div>
@endsection
