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

        // Get stock by category for charts
        $categories = Category::with('products')
            ->has('products')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'stock' => $category->products->sum('stock')
                ];
            });

        $categoryLabels = $categories->pluck('name')->toArray();
        $categoryStock = $categories->pluck('stock')->toArray();

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
            'categoryLabels' => $categoryLabels,
            'categoryStock' => $categoryStock,
        ]);
    }
}
