@extends('layouts.app')

@section('title', $category->name . ' | InventoryPro')
@section('page_title', $category->name)
@section('page_subtitle', 'Categoria')

@section('content')
<div class="d-flex justify-content-end gap-2 mb-3">
    @can('update', $category)
        <a class="btn btn-outline-primary" href="{{ route('categories.edit', $category) }}"><i class="bi bi-pencil me-1"></i>Editar</a>
    @endcan
</div>
<div class="panel p-4 mb-4">
    <h2 class="h6">Descripcion</h2>
    <p class="mb-0">{{ $category->description ?: 'Sin descripcion' }}</p>
</div>
<div class="panel">
    <div class="p-3 border-bottom"><h2 class="h6 mb-0">Productos de la categoria</h2></div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>SKU</th><th>Producto</th><th>Proveedor</th><th class="text-end">Stock</th></tr></thead>
            <tbody>
            @forelse ($category->products as $product)
                <tr>
                    <td>{{ $product->sku }}</td>
                    <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                    <td>{{ $product->supplier?->name }}</td>
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
