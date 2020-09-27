@extends('layouts.app')
@section('title', 'Тесты')
@section('content')
    <header class="s-content__header">
        <h1 class="s-text--title">@yield('title')</h1>
    </header>
    <div class="s-content__body">
        <tests></tests>
        <filemanager v-cloak inline-template>
            <div>
                <div v-if="inputName">@include('MediaManager::extras.modal')</div>

                {{-- for editor --}}
                @include('MediaManager::extras.editor')
            </div>
        </filemanager>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
@endpush
