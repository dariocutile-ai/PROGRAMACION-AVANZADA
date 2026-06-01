@extends('layouts.app')

@section('title', 'Productos | InventoryPro')
@section('page_title', 'Productos')
@section('page_subtitle', 'Catalogo con relaciones de categoria y proveedor')

@section('content')
<div class="panel mb-3 p-3">
    <form class="row g-2 align-items-end" method="get">
        <div class="col-md-4">
            <label class="form-label" for="q">Buscar</label>
            <input class="form-control" id="q" name="q" value="{{ request('q') }}" placeholder="Nombre o SKU">
        </div>
        <div class="col-md-3">
            <label class="form-label" for="category_id">Categoria</label>
            <select class="form-select" id="category_id" name="category_id">
                <option value="">Todas</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label" for="supplier_id">Proveedor</label>
            <select class="form-select" id="supplier_id" name="supplier_id">
                <option value="">Todos</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" @selected((string) request('supplier_id') === (string) $supplier->id)>{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-outline-secondary flex-fill" type="submit"><i class="bi bi-search"></i></button>
            @can('create', App\Models\Product::class)
                <a class="btn btn-primary flex-fill" href="{{ route('products.create') }}"><i class="bi bi-plus-lg"></i></a>
            @endcan
        </div>
    </form>
</div>

<div class="panel">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
            <tr>
                <th>SKU</th><th>Producto</th><th>Categoria</th><th>Proveedor</th>
                <th class="text-end">Stock</th><th class="text-end">Precio venta</th><th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($products as $product)
                <tr>
                    <td class="fw-semibold">{{ $product->sku }}</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        @if ($product->stock <= $product->reorder_level)
                            <span class="badge text-bg-warning ms-1">Stock bajo</span>
                        @endif
                    </td>
                    <td>{{ $product->category?->name }}</td>
                    <td>{{ $product->supplier?->name }}</td>
                    <td class="text-end">{{ $product->stock }}</td>
                    <td class="text-end">${{ number_format((float) $product->sale_price, 2) }}</td>
                    <td class="text-end">
                        <a class="btn btn-outline-secondary btn-sm btn-icon" title="Ver" href="{{ route('products.show', $product) }}"><i class="bi bi-eye"></i></a>
                        @can('update', $product)
                            <a class="btn btn-outline-primary btn-sm btn-icon" title="Editar" href="{{ route('products.edit', $product) }}"><i class="bi bi-pencil"></i></a>
                        @endcan
                        @can('delete', $product)
                            <form class="d-inline" method="post" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Eliminar producto?')">
                                @csrf @method('delete')
                                <button class="btn btn-outline-danger btn-sm btn-icon" title="Eliminar" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No hay productos para los filtros actuales.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $products->links() }}</div>
</div>
@endsection
