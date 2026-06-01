@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="name">Nombre</label>
        <input class="form-control" id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="email">Email</label>
        <input class="form-control" id="email" name="email" type="email" value="{{ old('email', $supplier->email) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="phone">Telefono</label>
        <input class="form-control" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="address">Direccion</label>
        <input class="form-control" id="address" name="address" value="{{ old('address', $supplier->address) }}">
    </div>
</div>
<div class="d-flex justify-content-end gap-2 mt-4">
    <a class="btn btn-outline-secondary" href="{{ route('suppliers.index') }}">Cancelar</a>
    <button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i>Guardar</button>
</div>
