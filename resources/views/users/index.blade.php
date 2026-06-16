@extends('layouts.app')

@section('title', 'Usuarios | InventoryPro')
@section('page_title', 'Usuarios')
@section('page_subtitle', 'Gestion completa con roles y permisos reales')

@section('content')
<div class="github-panel mb-3 p-3">
    <form class="row g-2 align-items-end" method="get">
        <div class="col-md-5">
            <label class="form-label" for="q">Buscar</label>
            <input class="form-control" id="q" name="q" value="{{ request('q') }}" placeholder="Nombre o email">
        </div>
        <div class="col-md-5">
            <label class="form-label" for="role_id">Rol</label>
            <select class="form-select" id="role_id" name="role_id">
                <option value="">Todos</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected((string) request('role_id') === (string) $role->id)>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-outline-secondary flex-fill github-btn" type="submit"><i class="bi bi-search"></i></button>
            @can('create', App\Models\User::class)
                <a class="btn btn-primary flex-fill github-btn" href="{{ route('users.create') }}"><i class="bi bi-plus-lg"></i></a>
            @endcan
        </div>
    </form>
</div>

<div class="github-panel">
    <div class="table-responsive">
        <table class="table table-hover mb-0 data-table">
            <thead>
            <tr>
                <th>Usuario</th>
                <th>Roles</th>
                <th>Creado</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>
                        <a href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
                        <div class="small text-muted">{{ $user->email }}</div>
                    </td>
                    <td>
                        @forelse ($user->roles as $role)
                            <span class="github-badge-soft">{{ $role->name }}</span>
                        @empty
                            <span class="text-muted">Sin rol</span>
                        @endforelse
                    </td>
                    <td>{{ $user->created_at?->format('Y-m-d') }}</td>
                    <td class="text-end">
                        <a class="btn btn-outline-secondary btn-sm github-btn-icon" title="Ver" href="{{ route('users.show', $user) }}"><i class="bi bi-eye"></i></a>
                        @can('update', $user)
                            <a class="btn btn-outline-primary btn-sm github-btn-icon" title="Editar" href="{{ route('users.edit', $user) }}"><i class="bi bi-pencil"></i></a>
                        @endcan
                        @can('delete', $user)
                            <form class="d-inline" method="post" action="{{ route('users.destroy', $user) }}" data-confirm="¿Desea eliminar el usuario {{ $user->name }}?">
                                @csrf @method('delete')
                                <button class="btn btn-outline-danger btn-sm github-btn-icon" title="Eliminar" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No hay usuarios para los filtros actuales.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $users->links() }}</div>
</div>
@endsection
