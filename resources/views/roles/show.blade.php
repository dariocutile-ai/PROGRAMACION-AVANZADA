@extends('layouts.app')

@section('title', 'Rol | InventoryPro')
@section('page_title', $role->name)
@section('page_subtitle', $role->description ?: 'Sin descripcion')

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="github-panel p-3 p-lg-4">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <div class="text-muted small">Rol</div>
                    <h2 class="h5 mb-1" style="color: #F0F6FC;">{{ $role->name }}</h2>
                    <div>{{ $role->description ?: 'Sin descripcion' }}</div>
                </div>
                <div class="d-flex gap-2">
                    @can('update', $role)
                        <a class="btn btn-outline-primary btn-sm github-btn-icon" title="Editar" href="{{ route('roles.edit', $role) }}"><i class="bi bi-pencil"></i></a>
                    @endcan
                    @can('delete', $role)
                        <form method="post" action="{{ route('roles.destroy', $role) }}" onsubmit="return confirm('Eliminar rol?')">
                            @csrf @method('delete')
                            <button class="btn btn-outline-danger btn-sm github-btn-icon" title="Eliminar" type="submit"><i class="bi bi-trash"></i></button>
                        </form>
                    @endcan
                </div>
            </div>
            <hr style="border-color: #30363D;">
            <dl class="row mb-0">
                <dt class="col-sm-5" style="color: #8B949E;">Usuarios</dt>
                <dd class="col-sm-7">{{ $role->users->count() }}</dd>
                <dt class="col-sm-5" style="color: #8B949E;">Creado</dt>
                <dd class="col-sm-7">{{ $role->created_at?->format('Y-m-d H:i') }}</dd>
                <dt class="col-sm-5" style="color: #8B949E;">Actualizado</dt>
                <dd class="col-sm-7">{{ $role->updated_at?->format('Y-m-d H:i') }}</dd>
            </dl>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="github-panel">
            <div class="p-3 border-bottom" style="border-bottom-color: #30363D;"><h2 class="h6 mb-0" style="color: #F0F6FC;">Usuarios con este rol</h2></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Usuario</th><th>Email</th></tr></thead>
                    <tbody>
                    @forelse ($role->users as $user)
                        <tr>
                            <td><a href="{{ route('users.show', $user) }}">{{ $user->name }}</a></td>
                            <td>{{ $user->email }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center text-muted py-4">No hay usuarios asociados a este rol.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
