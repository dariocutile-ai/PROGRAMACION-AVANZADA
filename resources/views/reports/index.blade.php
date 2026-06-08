@extends('layouts.app')

@section('title', 'Reportes | InventoryPro')
@section('page_title', 'Reportes')
@section('page_subtitle', 'Consultas reales generadas por ReportsService')

@section('content')
<div class="row g-4">
    <div class="col-xl-6">
        <div class="github-panel">
            <div class="p-3 border-bottom" style="border-bottom-color: #30363D;"><h2 class="h6 mb-0" style="color: #F0F6FC;">Stock bajo</h2></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Producto</th><th>Categoria</th><th class="text-end">Stock</th><th class="text-end">Minimo</th></tr></thead>
                    <tbody>
                    @forelse ($lowStock as $product)
                        <tr><td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td><td>{{ $product->category?->name }}</td><td class="text-end">{{ $product->stock }}</td><td class="text-end">{{ $product->reorder_level }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Sin alertas.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="github-panel">
            <div class="p-3 border-bottom" style="border-bottom-color: #30363D;"><h2 class="h6 mb-0" style="color: #F0F6FC;">Mas vendidos</h2></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Producto</th><th>Categoria</th><th class="text-end">Vendidos</th></tr></thead>
                    <tbody>
                    @forelse ($mostSold as $product)
                        <tr><td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td><td>{{ $product->category?->name }}</td><td class="text-end">{{ $product->total_sold }}</td></tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">Sin ventas registradas.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="github-panel">
            <div class="p-3 border-bottom" style="border-bottom-color: #30363D;"><h2 class="h6 mb-0" style="color: #F0F6FC;">Movimientos recientes</h2></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Fecha</th><th>Producto</th><th>Tipo</th><th class="text-end">Cantidad</th></tr></thead>
                    <tbody>
                    @foreach ($recentMovements as $movement)
                        <tr><td>{{ $movement->created_at?->format('Y-m-d H:i') }}</td><td>{{ $movement->product?->name }}</td><td><span class="github-badge-soft">{{ $movement->type }}</span></td><td class="text-end">{{ $movement->quantity }}</td></tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="github-panel">
            <div class="p-3 border-bottom" style="border-bottom-color: #30363D;">
                <form class="row g-2 align-items-end" method="get">
                    <div class="col">
                        <label class="form-label" for="category_id">Inventario por categoria</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">Todas</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) $selectedCategory === (string) $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto"><button class="btn btn-outline-secondary github-btn" type="submit"><i class="bi bi-funnel"></i></button></div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Producto</th><th>Proveedor</th><th class="text-end">Stock</th><th class="text-end">Valor</th></tr></thead>
                    <tbody>
                    @foreach ($byCategory as $product)
                        <tr><td>{{ $product->name }}</td><td>{{ $product->supplier?->name }}</td><td class="text-end">{{ $product->stock }}</td><td class="text-end">${{ number_format($product->stock * (float) $product->purchase_price, 2) }}</td></tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
