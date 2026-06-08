@extends('layouts.app')

@section('title', 'Nuevo producto | InventoryPro')
@section('page_title', 'Nuevo producto')
@section('page_subtitle', 'Formulario validado contra la tabla products')

@section('content')
<div class="github-panel p-4">
    <form method="post" action="{{ route('products.store') }}">
        @include('products._form')
    </form>
</div>
@endsection
