@extends('layouts.app')

@section('title', 'Movimientos | InventoryPro')
@section('page_title', 'Movimientos de inventario')
@section('page_subtitle', 'Historial paginado desde inventory_movements')

@section('content')
<div class="panel mb-3 p-3">
    <form class="row g-2 align-items-end" method="get">
        <div class="col-md-4">
            <label class="form-label" for="q">Buscar producto</label>
            <input class="form-control" id="q" name="q" value="{{ request('q') }}" placeholder="Nombre o SKU">
        </div>
        <div class="col-md-3">
            <label class="form-label" for="type">Tipo</label>
            <select class="form-select" id="type" name="type">
                <option value="">Todos</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}" @selected(request('type') === $type)>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label" for="product_id">Producto</label>
            <select class="form-select" id="product_id" name="product_id">
                <option value="">Todos</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" @selected((string) request('product_id') === (string) $product->id)>{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-outline-secondary flex-fill" type="submit"><i class="bi bi-search"></i></button>
            @can('create', App\Models\InventoryMovement::class)
                <a class="btn btn-primary flex-fill" href="{{ route('inventory.movements.create') }}"><i class="bi bi-plus-lg"></i></a>
            @endcan
        </div>
    </form>
</div>
<div class="panel">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Fecha</th><th>Producto</th><th>Tipo</th><th class="text-end">Cantidad</th><th class="text-end">Costo</th><th>Usuario</th><th></th></tr></thead>
            <tbody>
            @forelse ($movements as $movement)
                <tr>
                    <td>{{ $movement->created_at?->format('Y-m-d H:i') }}</td>
                    <td><a href="{{ route('products.show', $movement->product) }}">{{ $movement->product?->name }}</a><div class="small text-muted">{{ $movement->product?->sku }}</div></td>
                    <td><span class="badge badge-soft">{{ $movement->type }}</span></td>
                    <td class="text-end">{{ $movement->quantity }}</td>
                    <td class="text-end">${{ number_format((float) $movement->unit_cost, 2) }}</td>
                    <td>{{ $movement->user?->name ?? 'Sistema' }}</td>
                    <td class="text-end"><a class="btn btn-outline-secondary btn-sm btn-icon" href="{{ route('inventory.movements.show', $movement) }}" title="Ver"><i class="bi bi-eye"></i></a></td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No hay movimientos.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $movements->links() }}</div>
</div>
@endsection
