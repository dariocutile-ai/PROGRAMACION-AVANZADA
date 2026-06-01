@extends('layouts.app')

@section('title', 'Nuevo movimiento | InventoryPro')
@section('page_title', 'Nuevo movimiento')
@section('page_subtitle', 'Actualiza stock mediante InventoryService')

@section('content')
<div class="panel p-4">
    <form method="post" action="{{ route('inventory.movements.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="product_id">Producto</label>
                <select class="form-select" id="product_id" name="product_id" required>
                    <option value="">Seleccionar</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" @selected((string) old('product_id', request('product_id')) === (string) $product->id)>
                            {{ $product->name }} ({{ $product->sku }}) - stock {{ $product->stock }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="type">Tipo</label>
                <select class="form-select" id="type" name="type" required>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" @selected(old('type') === $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="quantity">Cantidad</label>
                <input class="form-control" id="quantity" name="quantity" type="number" min="1" value="{{ old('quantity', 1) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="unit_cost">Costo unitario</label>
                <input class="form-control" id="unit_cost" name="unit_cost" type="number" min="0" step="0.01" value="{{ old('unit_cost', 0) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="reference_type">Referencia</label>
                <input class="form-control" id="reference_type" name="reference_type" value="{{ old('reference_type') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="reference_id">ID referencia</label>
                <input class="form-control" id="reference_id" name="reference_id" type="number" min="1" value="{{ old('reference_id') }}">
            </div>
            <div class="col-12">
                <label class="form-label" for="note">Nota</label>
                <textarea class="form-control" id="note" name="note" rows="3">{{ old('note') }}</textarea>
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a class="btn btn-outline-secondary" href="{{ route('inventory.movements.index') }}">Cancelar</a>
            <button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i>Registrar</button>
        </div>
    </form>
</div>
@endsection
