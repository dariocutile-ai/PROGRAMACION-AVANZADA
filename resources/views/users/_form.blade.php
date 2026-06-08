@csrf
<div class="github-panel p-4">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label" for="name">Nombre</label>
            <input class="form-control" id="name" name="name" value="{{ old('name', $user?->name) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="email">Email</label>
            <input class="form-control" id="email" name="email" type="email" value="{{ old('email', $user?->email) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="password">Password</label>
            <input class="form-control" id="password" name="password" type="password" @if (! $user?->exists) required @endif>
            @if ($user?->exists)
                <div class="form-text">Dejalo vacio para conservar el password actual.</div>
            @endif
        </div>
        <div class="col-md-6">
            <label class="form-label" for="password_confirmation">Confirmar password</label>
            <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" @if (! $user?->exists) required @endif>
        </div>
        <div class="col-12">
            <label class="form-label">Roles</label>
            <div class="row g-2">
                @foreach ($roles as $role)
                    <div class="col-sm-6 col-lg-4">
                        <label class="border rounded-2 p-3 w-100 h-100" style="background: #161B22; border-color: #30363D;" for="role_{{ $role->id }}">
                            <span class="d-flex align-items-start gap-2">
                                <input
                                    class="form-check-input mt-1"
                                    id="role_{{ $role->id }}"
                                    name="roles[]"
                                    type="checkbox"
                                    value="{{ $role->id }}"
                                    @checked(in_array($role->id, old('roles', $selectedRoles ?? []), false))
                                >
                                <span>
                                    <span class="fw-semibold d-block" style="color: #F0F6FC;">{{ $role->name }}</span>
                                    <span class="small text-muted">{{ $role->description ?: 'Sin descripcion' }}</span>
                                </span>
                            </span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-2 mt-4">
        <a class="btn btn-outline-secondary github-btn" href="{{ route('users.index') }}">Cancelar</a>
        <button class="btn btn-primary github-btn" type="submit"><i class="bi bi-save me-1"></i>Guardar</button>
    </div>
</div>
