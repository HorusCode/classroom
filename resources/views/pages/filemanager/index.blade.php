@extends('layouts.app')
@section('title', trans('MediaManager::messages.title'))
@section('content')
    <div class="notif-container">
        <my-notification></my-notification>
    </div>
    <header class="s-content__header">
        <h1 class="s-text--title">@yield('title')</h1>
    </header>
    <div class="s-content__body">
{{-- TODO: Необходимо продумать модальное окно. И как будем разграничивать всякую чепуху для ролей--}}


        @include('MediaManager::_manager')
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
@endpush
