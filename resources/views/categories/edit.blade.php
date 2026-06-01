@extends('layouts.app')

@section('title', 'Editar categoria | InventoryPro')
@section('page_title', 'Editar categoria')
@section('page_subtitle', $category->name)

@section('content')
<div class="panel p-4">
    <form method="post" action="{{ route('categories.update', $category) }}">
        @method('put')
        @include('categories._form')
    </form>
</div>
@endsection
