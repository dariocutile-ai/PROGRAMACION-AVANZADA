@extends('layouts.app')

@section('title', 'Usuario | InventoryPro')
@section('page_title', $user->name)
@section('page_subtitle', $user->email)

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="panel p-3 p-lg-4">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <div class="text-muted-strong small">Usuario</div>
                    <h2 class="h5 mb-1">{{ $user->name }}</h2>
                    <div>{{ $user->email }}</div>
                </div>
                <div class="d-flex gap-2">
                    @can('update', $user)
                        <a class="btn btn-outline-primary btn-sm btn-icon" title="Editar" href="{{ route('users.edit', $user) }}"><i class="bi bi-pencil"></i></a>
                    @endcan
                    @can('delete', $user)
                        <form method="post" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Eliminar usuario?')">
                            @csrf @method('delete')
                            <button class="btn btn-outline-danger btn-sm btn-icon" title="Eliminar" type="submit"><i class="bi bi-trash"></i></button>
                        </form>
                    @endcan
                </div>
            </div>
            <hr>
            <dl class="row mb-0">
                <dt class="col-sm-5">Creado</dt>
                <dd class="col-sm-7">{{ $user->created_at?->format('Y-m-d H:i') }}</dd>
                <dt class="col-sm-5">Actualizado</dt>
                <dd class="col-sm-7">{{ $user->updated_at?->format('Y-m-d H:i') }}</dd>
            </dl>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="panel">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h2 class="h6 mb-0">Roles asignados</h2>
                @can('update', $user)
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('users.edit', $user) }}"><i class="bi bi-shield-check me-1"></i>Gestionar</a>
                @endcan
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Rol</th><th>Descripcion</th></tr></thead>
                    <tbody>
                    @forelse ($user->roles as $role)
                        <tr>
                            <td><a href="{{ route('roles.show', $role) }}">{{ $role->name }}</a></td>
                            <td>{{ $role->description ?: 'Sin descripcion' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center text-muted py-4">Este usuario no tiene roles asignados.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
