<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'InventoryPro')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="d-flex min-vh-100">
    @auth
        <aside class="sidebar" style="width: 260px; min-width: 260px; background: #161B22; border-right: 1px solid #30363D; padding: 16px;">
            <div class="d-flex align-items-center gap-2 mb-4">
                <div class="brand-mark-github"><i class="bi bi-box-seam"></i></div>
                <div>
                    <div class="fw-bold" style="color: #F0F6FC;">InventoryPro</div>
                    <small class="text-muted">{{ auth()->user()->roles->pluck('name')->join(', ') ?: 'Sin rol' }}</small>
                </div>
            </div>

            <nav class="nav flex-column gap-1">
                <a class="nav-link github-nav {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
                @can('viewAny', App\Models\Product::class)
                    <a class="nav-link github-nav {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="bi bi-boxes me-2"></i>Productos
                    </a>
                @endcan
                @can('viewAny', App\Models\Category::class)
                    <a class="nav-link github-nav {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                        <i class="bi bi-tags me-2"></i>Categorias
                    </a>
                @endcan
                @can('viewAny', App\Models\Supplier::class)
                    <a class="nav-link github-nav {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                        <i class="bi bi-truck me-2"></i>Proveedores
                    </a>
                @endcan
                @can('viewAny', App\Models\InventoryMovement::class)
                    <a class="nav-link github-nav {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.movements.index') }}">
                        <i class="bi bi-arrow-left-right me-2"></i>Movimientos
                    </a>
                @endcan
                @can('viewAny', App\Models\Report::class)
                    <a class="nav-link github-nav {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="bi bi-graph-up-arrow me-2"></i>Reportes
                    </a>
                @endcan
                @can('viewAny', App\Models\User::class)
                    <a class="nav-link github-nav {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="bi bi-people me-2"></i>Usuarios
                    </a>
                    <a class="nav-link github-nav {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <i class="bi bi-shield-lock me-2"></i>Roles
                    </a>
                @endcan
            </nav>
        </aside>
    @endauth

    <main class="flex-fill d-flex flex-column">
        @auth
            <header style="border-bottom: 1px solid #30363D; background: #161B22;">
                <div class="content-wrap mx-auto px-3 px-lg-4 py-3 d-flex justify-content-between align-items-center" style="max-width: 1440px;">
                    <div>
                        <h1 class="h4 mb-0" style="color: #F0F6FC;">@yield('page_title', 'InventoryPro')</h1>
                        @hasSection('page_subtitle')
                            <small class="text-muted">@yield('page_subtitle')</small>
                        @endif
                    </div>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-secondary btn-sm github-btn" type="submit">
                            <i class="bi bi-box-arrow-right me-1"></i>Salir
                        </button>
                    </form>
                </div>
            </header>
        @endauth

        <div class="content-wrap mx-auto px-3 px-lg-4 py-4 flex-fill" style="max-width: 1440px;">
            @if (session('success'))
                <div class="alert alert-success github-alert">{{ session('success') }}</div>
            @endif
            @if (session('status'))
                <div class="alert alert-info github-alert">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger github-alert">
                    <strong>Revisa los datos enviados.</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>

        @auth
            <footer style="border-top: 1px solid #30363D; background: #161B22;">
                <div class="content-wrap mx-auto px-3 px-lg-4 py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2" style="max-width: 1440px;">
                    <div class="small text-muted">
                        PROGRAMACION AVANZADA - 2026 - P1 - PARALELO 1
                    </div>
                    <div class="small text-muted">
                        Integrantes: Adrian Dario Mamani Cutile, Erick Jamil Limachi Mamani
                    </div>
                </div>
            </footer>
        @endauth
    </main>
</div>
</body>
</html>
