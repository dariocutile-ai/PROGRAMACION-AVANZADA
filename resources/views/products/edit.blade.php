@extends('layouts.app')

@section('title', 'Editar producto | InventoryPro')
@section('page_title', 'Editar producto')
@section('page_subtitle', $product->name)

@section('content')
<div class="github-panel p-4">
    <form method="post" action="{{ route('products.update', $product) }}">
        @method('put')
        @include('products._form')
    </form>
</div>
@endsection
