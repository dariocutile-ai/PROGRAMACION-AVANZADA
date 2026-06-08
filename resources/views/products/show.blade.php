@extends('layouts.app')

@section('title', $product->name . ' | InventoryPro')
@section('page_title', $product->name)
@section('page_subtitle', $product->sku)

@section('content')
<div class="d-flex justify-content-end gap-2 mb-3">
    @can('create', App\Models\InventoryMovement::class)
        <a class="btn btn-primary github-btn" href="{{ route('inventory.movements.create', ['product_id' => $product->id]) }}"><i class="bi bi-arrow-left-right me-1"></i>Movimiento</a>
    @endcan
    @can('update', $product)
        <a class="btn btn-outline-primary github-btn" href="{{ route('products.edit', $product) }}"><i class="bi bi-pencil me-1"></i>Editar</a>
    @endcan
</div>
<div class="row g-4">
    <div class="col-lg-5">
        <div class="github-panel p-4">
            <dl class="row mb-0">
                <dt class="col-sm-5" style="color: #8B949E;">Categoria</dt><dd class="col-sm-7">{{ $product->category?->name }}</dd>
                <dt class="col-sm-5" style="color: #8B949E;">Proveedor</dt><dd class="col-sm-7">{{ $product->supplier?->name }}</dd>
                <dt class="col-sm-5" style="color: #8B949E;">Stock</dt><dd class="col-sm-7">{{ $product->stock }} / minimo {{ $product->reorder_level }}</dd>
                <dt class="col-sm-5" style="color: #8B949E;">Compra</dt><dd class="col-sm-7">${{ number_format((float) $product->purchase_price, 2) }}</dd>
                <dt class="col-sm-5" style="color: #8B949E;">Venta</dt><dd class="col-sm-7">${{ number_format((float) $product->sale_price, 2) }}</dd>
                <dt class="col-sm-5" style="color: #8B949E;">Descripcion</dt><dd class="col-sm-7">{{ $product->description ?: 'Sin descripcion' }}</dd>
            </dl>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="github-panel">
            <div class="p-3 border-bottom" style="border-bottom-color: #30363D;"><h2 class="h6 mb-0" style="color: #F0F6FC;">Historial de movimientos</h2></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Fecha</th><th>Tipo</th><th class="text-end">Cantidad</th><th>Usuario</th></tr></thead>
                    <tbody>
                    @forelse ($product->inventoryMovements->sortByDesc('created_at') as $movement)
                        <tr>
                            <td>{{ $movement->created_at?->format('Y-m-d H:i') }}</td>
                            <td><span class="github-badge-soft">{{ $movement->type }}</span></td>
                            <td class="text-end">{{ $movement->quantity }}</td>
                            <td>{{ $movement->user?->name ?? 'Sistema' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Sin movimientos.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
