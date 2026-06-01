@extends('layouts.app')

@section('title', 'Movimiento #' . $movement->id . ' | InventoryPro')
@section('page_title', 'Movimiento #' . $movement->id)
@section('page_subtitle', $movement->created_at?->format('Y-m-d H:i'))

@section('content')
<div class="panel p-4">
    <dl class="row mb-0">
        <dt class="col-sm-3">Producto</dt><dd class="col-sm-9"><a href="{{ route('products.show', $movement->product) }}">{{ $movement->product?->name }}</a></dd>
        <dt class="col-sm-3">Categoria</dt><dd class="col-sm-9">{{ $movement->product?->category?->name }}</dd>
        <dt class="col-sm-3">Proveedor</dt><dd class="col-sm-9">{{ $movement->product?->supplier?->name }}</dd>
        <dt class="col-sm-3">Tipo</dt><dd class="col-sm-9"><span class="badge badge-soft">{{ $movement->type }}</span></dd>
        <dt class="col-sm-3">Cantidad</dt><dd class="col-sm-9">{{ $movement->quantity }}</dd>
        <dt class="col-sm-3">Costo unitario</dt><dd class="col-sm-9">${{ number_format((float) $movement->unit_cost, 2) }}</dd>
        <dt class="col-sm-3">Usuario</dt><dd class="col-sm-9">{{ $movement->user?->name ?? 'Sistema' }}</dd>
        <dt class="col-sm-3">Nota</dt><dd class="col-sm-9">{{ $movement->note ?: '-' }}</dd>
    </dl>
</div>
@endsection
