<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'InventoryPro')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="d-flex min-vh-100">
    @auth
        <aside class="sidebar" style="width: 260px; min-width: 260px; background: #161B22; border-right: 1px solid #30363D; padding: 16px; position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; transition: width 0.3s ease;">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="brand-mark-github"><i class="bi bi-box-seam"></i></div>
                    <div>
                        <div class="fw-bold" style="color: #F0F6FC;">InventoryPro</div>
                        <small class="text-muted">{{ auth()->user()->roles->pluck('name')->join(', ') ?: 'Sin rol' }}</small>
                    </div>
                </div>
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list" id="toggle-icon"></i>
                </button>
            </div>

            <nav class="nav flex-column gap-1">
                <a class="nav-link github-nav {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span>
                </a>
                @can('viewAny', App\Models\Product::class)
                    <a class="nav-link github-nav {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="bi bi-boxes me-2"></i><span>Productos</span>
                    </a>
                @endcan
                @can('viewAny', App\Models\Category::class)
                    <a class="nav-link github-nav {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                        <i class="bi bi-tags me-2"></i><span>Categorias</span>
                    </a>
                @endcan
                @can('viewAny', App\Models\Supplier::class)
                    <a class="nav-link github-nav {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                        <i class="bi bi-truck me-2"></i><span>Proveedores</span>
                    </a>
                @endcan
                @can('viewAny', App\Models\InventoryMovement::class)
                    <a class="nav-link github-nav {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.movements.index') }}">
                        <i class="bi bi-arrow-left-right me-2"></i><span>Movimientos</span>
                    </a>
                @endcan
                @can('viewAny', App\Models\Report::class)
                    <a class="nav-link github-nav {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="bi bi-graph-up-arrow me-2"></i><span>Reportes</span>
                    </a>
                @endcan
                @can('viewAny', App\Models\User::class)
                    <a class="nav-link github-nav {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="bi bi-people me-2"></i><span>Usuarios</span>
                    </a>
                    <a class="nav-link github-nav {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <i class="bi bi-shield-lock me-2"></i><span>Roles</span>
                    </a>
                @endcan
            </nav>
        </aside>
    @endauth

    <main class="flex-fill d-flex flex-column" style="margin-left: 260px;">
        @auth
            <header style="border-bottom: 1px solid #30363D; background: #161B22; position: sticky; top: 0; z-index: 1000;">
                <div class="content-wrap mx-auto px-3 px-lg-4 py-3 d-flex justify-content-between align-items-center" style="max-width: 1440px;">
                    <div>
                        <h1 class="h4 mb-0" style="color: #F0F6FC;">@yield('page_title', 'InventoryPro')</h1>
                        @hasSection('page_subtitle')
                            <small class="text-muted">@yield('page_subtitle')</small>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm github-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>
                                <span>{{ auth()->user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="background: var(--gh-bg-secondary); border: 1px solid var(--gh-border);">
                                <li><span class="dropdown-header" style="color: var(--gh-text-secondary);">{{ auth()->user()->email }}</span></li>
                                <li><hr class="dropdown-divider" style="border-color: var(--gh-border);"></li>
                                <li>
                                    <form method="post" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" style="color: var(--gh-text-primary); background: transparent;" type="submit">
                                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sidebar toggle functionality
    let sidebarCollapsed = false;
    
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const main = document.querySelector('main');
        const toggleIcon = document.getElementById('toggle-icon');
        const body = document.body;
        
        sidebarCollapsed = !sidebarCollapsed;
        
        if (sidebarCollapsed) {
            body.classList.add('sidebar-collapsed');
            toggleIcon.classList.remove('bi-list');
            toggleIcon.classList.add('bi-list');
        } else {
            body.classList.remove('sidebar-collapsed');
        }
    }

    // DataTables initialization
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTables on all tables with .data-table class
        const tables = document.querySelectorAll('.data-table');
        tables.forEach(function(table) {
            $(table).DataTable({
                responsive: true,
                pageLength: 25,
                language: {
                    search: "_INPUT_",
                    lengthMenu: "_MENU_",
                    info: "_MENU_",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                }
            });
        });

        // Initialize SweetAlert2 for form confirmations
        const confirmForms = document.querySelectorAll('form[onsubmit*="confirm"]');
        confirmForms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const confirmMsg = form.getAttribute('onsubmit');
                if (confirmMsg && confirmMsg.includes('confirm')) {
                    const message = confirmMsg.replace('return confirm(\'', '').replace('\')', '');
                    if (confirm(message)) {
                        form.submit();
                    } else {
                        e.preventDefault();
                    }
                }
            });
        });
    });
</script>
</body>
</html>
