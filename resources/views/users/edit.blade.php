@extends('layouts.app')

@section('title', 'Editar usuario | InventoryPro')
@section('page_title', 'Editar usuario')
@section('page_subtitle', $user->name)

@section('content')
<div class="panel p-3 p-lg-4">
    <form method="post" action="{{ route('users.update', $user) }}">
        @method('put')
        @include('users._form')
    </form>
</div>
@endsection
