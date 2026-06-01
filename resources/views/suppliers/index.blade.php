@extends('layouts.app')

@section('title', 'Proveedores | InventoryPro')
@section('page_title', 'Proveedores')
@section('page_subtitle', 'Contactos vinculados a productos')

@section('content')
<div class="panel mb-3 p-3">
    <form class="row g-2 align-items-end" method="get">
        <div class="col-md-10">
            <label class="form-label" for="q">Buscar</label>
            <input class="form-control" id="q" name="q" value="{{ request('q') }}" placeholder="Nombre o email">
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-outline-secondary flex-fill" type="submit"><i class="bi bi-search"></i></button>
            @can('create', App\Models\Supplier::class)
                <a class="btn btn-primary flex-fill" href="{{ route('suppliers.create') }}"><i class="bi bi-plus-lg"></i></a>
            @endcan
        </div>
    </form>
</div>
<div class="panel">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Proveedor</th><th>Email</th><th>Telefono</th><th class="text-end">Productos</th><th class="text-end">Acciones</th></tr></thead>
            <tbody>
            @forelse ($suppliers as $supplier)
                <tr>
                    <td><a href="{{ route('suppliers.show', $supplier) }}">{{ $supplier->name }}</a></td>
                    <td>{{ $supplier->email ?: '-' }}</td>
                    <td>{{ $supplier->phone ?: '-' }}</td>
                    <td class="text-end">{{ $supplier->products_count }}</td>
                    <td class="text-end">
                        <a class="btn btn-outline-secondary btn-sm btn-icon" href="{{ route('suppliers.show', $supplier) }}" title="Ver"><i class="bi bi-eye"></i></a>
                        @can('update', $supplier)
                            <a class="btn btn-outline-primary btn-sm btn-icon" href="{{ route('suppliers.edit', $supplier) }}" title="Editar"><i class="bi bi-pencil"></i></a>
                        @endcan
                        @can('delete', $supplier)
                            <form class="d-inline" method="post" action="{{ route('suppliers.destroy', $supplier) }}" onsubmit="return confirm('Eliminar proveedor?')">
                                @csrf @method('delete')
                                <button class="btn btn-outline-danger btn-sm btn-icon" type="submit" title="Eliminar"><i class="bi bi-trash"></i></button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay proveedores.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $suppliers->links() }}</div>
</div>
@endsection
