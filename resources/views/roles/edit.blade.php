@extends('layouts.app')

@section('title', 'Editar rol | InventoryPro')
@section('page_title', 'Editar rol')
@section('page_subtitle', $role->name)

@section('content')
<div class="github-panel p-3 p-lg-4">
    <form method="post" action="{{ route('roles.update', $role) }}">
        @method('put')
        @include('roles._form')
    </form>
</div>
@endsection
