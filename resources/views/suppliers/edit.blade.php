@extends('layouts.app')

@section('title', 'Editar proveedor | InventoryPro')
@section('page_title', 'Editar proveedor')
@section('page_subtitle', $supplier->name)

@section('content')
<div class="github-panel p-4">
    <form method="post" action="{{ route('suppliers.update', $supplier) }}">
        @method('put')
        @include('suppliers._form')
    </form>
</div>
@endsection
