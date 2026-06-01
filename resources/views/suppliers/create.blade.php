@extends('layouts.app')

@section('title', 'Nuevo proveedor | InventoryPro')
@section('page_title', 'Nuevo proveedor')

@section('content')
<div class="panel p-4">
    <form method="post" action="{{ route('suppliers.store') }}">
        @include('suppliers._form')
    </form>
</div>
@endsection
