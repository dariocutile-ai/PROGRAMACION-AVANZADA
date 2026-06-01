@extends('layouts.app')

@section('title', 'Nuevo rol | InventoryPro')
@section('page_title', 'Nuevo rol')
@section('page_subtitle', 'Permisos por rol aplicados por policies y middleware')

@section('content')
<div class="panel p-3 p-lg-4">
    <form method="post" action="{{ route('roles.store') }}">
        @include('roles._form')
    </form>
</div>
@endsection
