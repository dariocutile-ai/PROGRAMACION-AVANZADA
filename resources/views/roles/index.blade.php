@extends('layouts.app')

@section('title', 'Roles | InventoryPro')
@section('page_title', 'Roles')
@section('page_subtitle', 'Control de acceso usado por el sistema')

@section('content')
<div class="panel mb-3 p-3">
    <form class="row g-2 align-items-end" method="get">
        <div class="col-md-10">
            <label class="form-label" for="q">Buscar</label>
            <input class="form-control" id="q" name="q" value="{{ request('q') }}" placeholder="Nombre de rol">
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-outline-secondary flex-fill" type="submit"><i class="bi bi-search"></i></button>
            @can('create', App\Models\Role::class)
                <a class="btn btn-primary flex-fill" href="{{ route('roles.create') }}"><i class="bi bi-plus-lg"></i></a>
            @endcan
        </div>
    </form>
</div>

<div class="panel">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Rol</th><th>Descripcion</th><th class="text-end">Usuarios</th><th class="text-end">Acciones</th></tr></thead>
            <tbody>
            @forelse ($roles as $role)
                <tr>
                    <td><a href="{{ route('roles.show', $role) }}">{{ $role->name }}</a></td>
                    <td>{{ $role->description ?: 'Sin descripcion' }}</td>
                    <td class="text-end">{{ $role->users_count }}</td>
                    <td class="text-end">
                        <a class="btn btn-outline-secondary btn-sm btn-icon" href="{{ route('roles.show', $role) }}" title="Ver"><i class="bi bi-eye"></i></a>
                        @can('update', $role)
                            <a class="btn btn-outline-primary btn-sm btn-icon" href="{{ route('roles.edit', $role) }}" title="Editar"><i class="bi bi-pencil"></i></a>
                        @endcan
                        @can('delete', $role)
                            <form class="d-inline" method="post" action="{{ route('roles.destroy', $role) }}" onsubmit="return confirm('Eliminar rol?')">
                                @csrf @method('delete')
                                <button class="btn btn-outline-danger btn-sm btn-icon" type="submit" title="Eliminar"><i class="bi bi-trash"></i></button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No hay roles.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $roles->links() }}</div>
</div>
@endsection
