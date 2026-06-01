@csrf
<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label" for="sku">SKU</label>
        <input class="form-control" id="sku" name="sku" value="{{ old('sku', $product?->sku) }}" required>
    </div>
    <div class="col-md-9">
        <label class="form-label" for="name">Nombre</label>
        <input class="form-control" id="name" name="name" value="{{ old('name', $product?->name) }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="category_id">Categoria</label>
        <select class="form-select" id="category_id" name="category_id" required>
            <option value="">Seleccionar</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $product?->category_id) === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="supplier_id">Proveedor</label>
        <select class="form-select" id="supplier_id" name="supplier_id" required>
            <option value="">Seleccionar</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" @selected((string) old('supplier_id', $product?->supplier_id) === (string) $supplier->id)>{{ $supplier->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="stock">Stock</label>
        <input class="form-control" id="stock" name="stock" type="number" min="0" value="{{ old('stock', $product?->stock ?? 0) }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="reorder_level">Stock minimo</label>
        <input class="form-control" id="reorder_level" name="reorder_level" type="number" min="0" value="{{ old('reorder_level', $product?->reorder_level ?? 0) }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="purchase_price">Precio compra</label>
        <input class="form-control" id="purchase_price" name="purchase_price" type="number" min="0" step="0.01" value="{{ old('purchase_price', $product?->purchase_price ?? 0) }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="sale_price">Precio venta</label>
        <input class="form-control" id="sale_price" name="sale_price" type="number" min="0" step="0.01" value="{{ old('sale_price', $product?->sale_price ?? 0) }}" required>
    </div>
    <div class="col-12">
        <label class="form-label" for="description">Descripcion</label>
        <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product?->description) }}</textarea>
    </div>
</div>
<div class="d-flex justify-content-end gap-2 mt-4">
    <a class="btn btn-outline-secondary" href="{{ route('products.index') }}">Cancelar</a>
    <button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i>Guardar</button>
</div>
