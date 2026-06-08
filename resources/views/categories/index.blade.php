@extends('layouts.app')

@section('title', 'Categorias | InventoryPro')
@section('page_title', 'Categorias')
@section('page_subtitle', 'Agrupacion real de productos')

@section('content')
<div class="github-panel mb-3 p-3">
    <form class="row g-2 align-items-end" method="get">
        <div class="col-md-10">
            <label class="form-label" for="q">Buscar</label>
            <input class="form-control" id="q" name="q" value="{{ request('q') }}" placeholder="Nombre de categoria">
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-outline-secondary flex-fill github-btn" type="submit"><i class="bi bi-search"></i></button>
            @can('create', App\Models\Category::class)
                <a class="btn btn-primary flex-fill github-btn" href="{{ route('categories.create') }}"><i class="bi bi-plus-lg"></i></a>
            @endcan
        </div>
    </form>
</div>
<div class="github-panel">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Nombre</th><th>Descripcion</th><th class="text-end">Productos</th><th class="text-end">Acciones</th></tr></thead>
            <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td><a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a></td>
                    <td>{{ $category->description ?: 'Sin descripcion' }}</td>
                    <td class="text-end">{{ $category->products_count }}</td>
                    <td class="text-end">
                        <a class="btn btn-outline-secondary btn-sm github-btn-icon" href="{{ route('categories.show', $category) }}" title="Ver"><i class="bi bi-eye"></i></a>
                        @can('update', $category)
                            <a class="btn btn-outline-primary btn-sm github-btn-icon" href="{{ route('categories.edit', $category) }}" title="Editar"><i class="bi bi-pencil"></i></a>
                        @endcan
                        @can('delete', $category)
                            <form class="d-inline" method="post" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Eliminar categoria?')">
                                @csrf @method('delete')
                                <button class="btn btn-outline-danger btn-sm github-btn-icon" type="submit" title="Eliminar"><i class="bi bi-trash"></i></button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No hay categorias.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $categories->links() }}</div>
</div>
@endsection
