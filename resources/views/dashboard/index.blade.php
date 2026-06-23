@extends('layouts.app')

@section('title', 'Dashboard | InventoryPro')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Indicadores calculados desde la base de datos')

@section('content')
<div class="row g-3 mb-4">
    @foreach ([
        ['label' => 'Productos', 'value' => $totals['products'], 'icon' => 'bi-boxes', 'color' => '#2F81F7', 'bg' => 'rgba(47, 129, 247, 0.1)'],
        ['label' => 'Categorias', 'value' => $totals['categories'], 'icon' => 'bi-tags', 'color' => '#A371F7', 'bg' => 'rgba(163, 113, 247, 0.1)'],
        ['label' => 'Proveedores', 'value' => $totals['suppliers'], 'icon' => 'bi-truck', 'color' => '#238636', 'bg' => 'rgba(35, 134, 54, 0.1)'],
        ['label' => 'Usuarios', 'value' => $totals['users'], 'icon' => 'bi-people', 'color' => '#D29922', 'bg' => 'rgba(210, 153, 34, 0.1)'],
        ['label' => 'Stock disponible', 'value' => $totals['stock'], 'icon' => 'bi-stack', 'color' => '#2F81F7', 'bg' => 'rgba(47, 129, 247, 0.1)'],
        ['label' => 'Stock bajo', 'value' => $totals['low_stock'], 'icon' => 'bi-exclamation-triangle', 'color' => '#DA3633', 'bg' => 'rgba(218, 54, 51, 0.1)'],
    ] as $metric)
        <div class="col-sm-6 col-xl-4">
            <div class="github-metric d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">{{ $metric['label'] }}</div>
                    <div class="fs-3 fw-bold mt-1" style="color: #F0F6FC;">{{ number_format($metric['value']) }}</div>
                    <div class="small text-muted mt-1">
                        @if($metric['label'] === 'Stock bajo' && $totals['low_stock'] > 0)
                            <span class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>Requiere atención</span>
                        @elseif($metric['label'] === 'Stock bajo' && $totals['low_stock'] === 0)
                            <span class="text-success"><i class="bi bi-check-circle me-1"></i>Todo en orden</span>
                        @endif
                    </div>
                </div>
                <div class="icon-container" style="width: 56px; height: 56px; display: grid; place-items: center; background: {{ $metric['bg'] }}; border-radius: 8px;">
                    <i class="bi {{ $metric['icon'] }} fs-3" style="color: {{ $metric['color'] }}; font-size: 28px;"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="github-panel">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="border-bottom-color: #30363D;">
                <h2 class="h6 mb-0" style="color: #F0F6FC;"><i class="bi bi-graph-up me-2"></i>Stock por Categoría</h2>
                <span class="badge bg-primary" style="background: var(--gh-blue);">Gráfico</span>
            </div>
            <div class="p-3">
                <canvas id="stockByCategoryChart" style="max-height: 350px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="github-panel">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="border-bottom-color: #30363D;">
                <h2 class="h6 mb-0" style="color: #F0F6FC;"><i class="bi bi-pie-chart me-2"></i>Distribución de Stock</h2>
                <span class="badge bg-primary" style="background: var(--gh-purple);">Pie</span>
            </div>
            <div class="p-3">
                <canvas id="stockDistributionChart" style="max-height: 350px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-6">
        <div class="github-panel">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="border-bottom-color: #30363D;">
                <h2 class="h6 mb-0" style="color: #F0F6FC;"><i class="bi bi-exclamation-triangle me-2"></i>Productos con stock bajo</h2>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm github-btn">Ver reporte</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 data-table">
                    <thead><tr><th>Producto</th><th>Categoría</th><th class="text-end">Stock</th><th class="text-end">Mínimo</th></tr></thead>
                    <tbody>
                    @forelse ($lowStockProducts as $product)
                        <tr>
                            <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a><div class="small text-muted">{{ $product->sku }}</div></td>
                            <td>{{ $product->category?->name }}</td>
                            <td class="text-end">
                                @if($product->stock == 0)
                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Agotado (0)</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td class="text-end">{{ $product->reorder_level }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No hay productos bajo el mínimo.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="github-panel">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="border-bottom-color: #30363D;">
                <h2 class="h6 mb-0" style="color: #F0F6FC;"><i class="bi bi-clock-history me-2"></i>Últimos movimientos</h2>
                @can('create', App\Models\InventoryMovement::class)
                    <a href="{{ route('inventory.movements.create') }}" class="btn btn-primary btn-sm github-btn"><i class="bi bi-plus-lg me-1"></i>Registrar</a>
                @endcan
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 data-table">
                    <thead><tr><th>Producto</th><th>Tipo</th><th class="text-end">Cantidad</th><th>Usuario</th></tr></thead>
                    <tbody>
                    @forelse ($recentMovements as $movement)
                        <tr>
                            <td><a href="{{ route('inventory.movements.show', $movement) }}">{{ $movement->product?->name }}</a></td>
                            <td><span class="github-badge-soft">{{ ['purchase'=>'Compra','restock'=>'Reabastecimiento','sale'=>'Venta','waste'=>'Merma'][$movement->type] ?? $movement->type }}</span></td>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Stock by Category Chart
    const stockByCategoryCtx = document.getElementById('stockByCategoryChart').getContext('2d');
    new Chart(stockByCategoryCtx, {
        type: 'bar',
        data: {
            labels: @json($categoryLabels ?? []),
            datasets: [{
                label: 'Stock Total',
                data: @json($categoryStock ?? []),
                backgroundColor: 'rgba(47, 129, 247, 0.5)',
                borderColor: '#2F81F7',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(248, 81, 73, 0.1)'
                    },
                    ticks: {
                        color: '#8B949E'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#8B949E'
                    }
                }
            }
        }
    });

    // Stock Distribution Pie Chart
    const stockDistributionCtx = document.getElementById('stockDistributionChart').getContext('2d');
    new Chart(stockDistributionCtx, {
        type: 'doughnut',
        data: {
            labels: @json($categoryLabels ?? []),
            datasets: [{
                data: @json($categoryStock ?? []),
                backgroundColor: [
                    '#2F81F7',
                    '#238636',
                    '#A371F7',
                    '#D29922',
                    '#DA3633',
                    '#E3B341'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#8B949E',
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
});
</script>
@endsection
