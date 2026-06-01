<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        Gate::authorize('viewAny', Product::class);

        return view('dashboard.index', [
            'totals' => [
                'products' => Product::count(),
                'categories' => Category::count(),
                'suppliers' => Supplier::count(),
                'users' => User::count(),
                'stock' => (int) Product::sum('stock'),
                'low_stock' => Product::lowStock()->count(),
            ],
            'lowStockProducts' => Product::query()
                ->with(['category', 'supplier'])
                ->lowStock()
                ->orderBy('stock')
                ->limit(8)
                ->get(),
            'recentMovements' => InventoryMovement::query()
                ->with(['product.category', 'user'])
                ->latest()
                ->limit(8)
                ->get(),
        ]);
    }
}
