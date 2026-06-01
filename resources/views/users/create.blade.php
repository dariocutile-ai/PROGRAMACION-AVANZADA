@extends('layouts.app')

@section('title', 'Nuevo usuario | InventoryPro')
@section('page_title', 'Nuevo usuario')
@section('page_subtitle', 'Alta conectada a roles reales del sistema')

@section('content')
<div class="panel p-3 p-lg-4">
    <form method="post" action="{{ route('users.store') }}">
        @include('users._form')
    </form>
</div>
@endsection
