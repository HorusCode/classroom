@extends('layouts.app')
@section('title', 'Редактировать курс')
@section('content')
    <header class="s-content__header">
        <h1 class="s-text--title">Просмотр курса</h1>
    </header>
    <div class="s-content__body">
        <courses-show :data-id="{{ request()->id }}"></courses-show>
    </div>
@endsection
