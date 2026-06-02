<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'InventoryPro')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --ip-ink: #17202a;
            --ip-muted: #65758b;
            --ip-line: #d9e1ea;
            --ip-bg: #f6f8fb;
            --ip-accent: #0f766e;
        }
        body { background: var(--ip-bg); color: var(--ip-ink); }
        .app-shell { min-height: 100vh; }
        .sidebar { background: #ffffff; border-right: 1px solid var(--ip-line); width: 260px; }
        .brand-mark { width: 36px; height: 36px; display: grid; place-items: center; background: var(--ip-accent); color: #fff; border-radius: 8px; }
        .nav-link { color: #334155; border-radius: 8px; }
        .nav-link.active, .nav-link:hover { background: #e8f3f1; color: #0f5f59; }
        .content-wrap { max-width: 1440px; }
        .metric { border: 1px solid var(--ip-line); border-radius: 8px; background: #fff; }
        .panel { border: 1px solid var(--ip-line); border-radius: 8px; background: #fff; }
        .table > :not(caption) > * > * { vertical-align: middle; }
        .text-muted-strong { color: var(--ip-muted); }
        .btn-icon { width: 2.25rem; height: 2.25rem; display: inline-grid; place-items: center; }
        .badge-soft { background: #edf2f7; color: #314256; }
        @media (max-width: 991.98px) {
            .sidebar { width: 100%; border-right: 0; border-bottom: 1px solid var(--ip-line); }
        }
    </style>
</head>
<body>
<div class="app-shell d-lg-flex">
    @auth
        <aside class="sidebar p-3">
            <div class="d-flex align-items-center gap-2 mb-4">
                <div class="brand-mark"><i class="bi bi-box-seam"></i></div>
                <div>
                    <div class="fw-bold">InventoryPro</div>
                    <small class="text-muted-strong">{{ auth()->user()->roles->pluck('name')->join(', ') ?: 'Sin rol' }}</small>
                </div>
            </div>

            <nav class="nav flex-column gap-1">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                @can('viewAny', App\Models\Product::class)
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}"><i class="bi bi-boxes me-2"></i>Productos</a>
                @endcan
                @can('viewAny', App\Models\Category::class)
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}"><i class="bi bi-tags me-2"></i>Categorias</a>
                @endcan
                @can('viewAny', App\Models\Supplier::class)
                    <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}"><i class="bi bi-truck me-2"></i>Proveedores</a>
                @endcan
                @can('viewAny', App\Models\InventoryMovement::class)
                    <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.movements.index') }}"><i class="bi bi-arrow-left-right me-2"></i>Movimientos</a>
                @endcan
                @can('viewAny', App\Models\Report::class)
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}"><i class="bi bi-graph-up-arrow me-2"></i>Reportes</a>
                @endcan
                @can('viewAny', App\Models\User::class)
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="bi bi-people me-2"></i>Usuarios</a>
                    <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}"><i class="bi bi-shield-lock me-2"></i>Roles</a>
                @endcan
            </nav>
        </aside>
    @endauth

    <main class="flex-fill">
        @auth
            <header class="border-bottom bg-white">
                <div class="content-wrap mx-auto px-3 px-lg-4 py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h4 mb-0">@yield('page_title', 'InventoryPro')</h1>
                        @hasSection('page_subtitle')
                            <small class="text-muted-strong">@yield('page_subtitle')</small>
                        @endif
                    </div>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="bi bi-box-arrow-right me-1"></i>Salir</button>
                    </form>
                </div>
            </header>
        @endauth

        <div class="content-wrap mx-auto px-3 px-lg-4 py-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('status'))
                <div class="alert alert-info">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
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
            <footer class="border-top bg-white">
                <div class="content-wrap mx-auto px-3 px-lg-4 py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <div class="small text-muted-strong">
                        PROGRAMACION AVANZADA - 2026 - P1 - PARALELO 1
                    </div>
                    <div class="small text-muted-strong">
                        Integrantes: Adrian Mamani, Dario Mamani Cutile, Erick Jamil Limachi Mamani
                    </div>
                </div>
            </footer>
        @endauth
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
