@extends('layouts.app')

@section('title', $supplier->name . ' | InventoryPro')
@section('page_title', $supplier->name)
@section('page_subtitle', 'Proveedor')

@section('content')
<div class="d-flex justify-content-end gap-2 mb-3">
    @can('update', $supplier)
        <a class="btn btn-outline-primary github-btn" href="{{ route('suppliers.edit', $supplier) }}"><i class="bi bi-pencil me-1"></i>Editar</a>
    @endcan
</div>
<div class="github-panel p-4 mb-4">
    <dl class="row mb-0">
        <dt class="col-sm-3" style="color: #8B949E;">Email</dt><dd class="col-sm-9">{{ $supplier->email ?: '-' }}</dd>
        <dt class="col-sm-3" style="color: #8B949E;">Telefono</dt><dd class="col-sm-9">{{ $supplier->phone ?: '-' }}</dd>
        <dt class="col-sm-3" style="color: #8B949E;">Direccion</dt><dd class="col-sm-9">{{ $supplier->address ?: '-' }}</dd>
    </dl>
</div>
<div class="github-panel">
    <div class="p-3 border-bottom" style="border-bottom-color: #30363D;"><h2 class="h6 mb-0" style="color: #F0F6FC;">Productos del proveedor</h2></div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>SKU</th><th>Producto</th><th>Categoria</th><th class="text-end">Stock</th></tr></thead>
            <tbody>
            @forelse ($supplier->products as $product)
                <tr>
                    <td>{{ $product->sku }}</td>
                    <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                    <td>{{ $product->category?->name }}</td>
                    <td class="text-end">{{ $product->stock }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Sin productos asociados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
