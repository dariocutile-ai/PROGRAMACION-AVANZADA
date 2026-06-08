@extends('layouts.app')

@section('title', 'Dashboard | InventoryPro')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Indicadores calculados desde la base de datos')

@section('content')
<div class="row g-3 mb-4">
    @foreach ([
        ['label' => 'Productos', 'value' => $totals['products'], 'icon' => 'bi-boxes', 'color' => '#2F81F7'],
        ['label' => 'Categorias', 'value' => $totals['categories'], 'icon' => 'bi-tags', 'color' => '#A371F7'],
        ['label' => 'Proveedores', 'value' => $totals['suppliers'], 'icon' => 'bi-truck', 'color' => '#238636'],
        ['label' => 'Usuarios', 'value' => $totals['users'], 'icon' => 'bi-people', 'color' => '#D29922'],
        ['label' => 'Stock disponible', 'value' => $totals['stock'], 'icon' => 'bi-stack', 'color' => '#2F81F7'],
        ['label' => 'Stock bajo', 'value' => $totals['low_stock'], 'icon' => 'bi-exclamation-triangle', 'color' => '#DA3633'],
    ] as $metric)
        <div class="col-sm-6 col-xl-4">
            <div class="github-metric d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">{{ $metric['label'] }}</div>
                    <div class="fs-3 fw-bold mt-1" style="color: #F0F6FC;">{{ number_format($metric['value']) }}</div>
                </div>
                <div class="icon-container" style="width: 48px; height: 48px; display: grid; place-items: center; background: {{ $metric['color'] }}20; border-radius: 6px;">
                    <i class="bi {{ $metric['icon'] }} fs-3" style="color: {{ $metric['color'] }};"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-xl-6">
        <div class="github-panel">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="border-bottom-color: #30363D;">
                <h2 class="h6 mb-0" style="color: #F0F6FC;">Productos con stock bajo</h2>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm github-btn">Ver reporte</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Producto</th><th>Categoria</th><th class="text-end">Stock</th><th class="text-end">Minimo</th></tr></thead>
                    <tbody>
                    @forelse ($lowStockProducts as $product)
                        <tr>
                            <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a><div class="small text-muted">{{ $product->sku }}</div></td>
                            <td>{{ $product->category?->name }}</td>
                            <td class="text-end">{{ $product->stock }}</td>
                            <td class="text-end">{{ $product->reorder_level }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No hay productos bajo el minimo.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="github-panel">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="border-bottom-color: #30363D;">
                <h2 class="h6 mb-0" style="color: #F0F6FC;">Ultimos movimientos</h2>
                @can('create', App\Models\InventoryMovement::class)
                    <a href="{{ route('inventory.movements.create') }}" class="btn btn-primary btn-sm github-btn"><i class="bi bi-plus-lg me-1"></i>Registrar</a>
                @endcan
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Producto</th><th>Tipo</th><th class="text-end">Cantidad</th><th>Usuario</th></tr></thead>
                    <tbody>
                    @forelse ($recentMovements as $movement)
                        <tr>
                            <td><a href="{{ route('inventory.movements.show', $movement) }}">{{ $movement->product?->name }}</a></td>
                            <td><span class="github-badge-soft">{{ $movement->type }}</span></td>
                            <td class="text-end">{{ $movement->quantity }}</td>
                            <td>{{ $movement->user?->name ?? 'Sistema' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No hay movimientos registrados.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
