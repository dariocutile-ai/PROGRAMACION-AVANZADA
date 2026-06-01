@csrf
<div class="row g-3">
    <div class="col-md-5">
        <label class="form-label" for="name">Nombre</label>
        <input class="form-control" id="name" name="name" value="{{ old('name', $role?->name) }}" required>
    </div>
    <div class="col-md-7">
        <label class="form-label" for="description">Descripcion</label>
        <input class="form-control" id="description" name="description" value="{{ old('description', $role?->description) }}">
    </div>
</div>
<div class="d-flex justify-content-end gap-2 mt-4">
    <a class="btn btn-outline-secondary" href="{{ route('roles.index') }}">Cancelar</a>
    <button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i>Guardar</button>
</div>
