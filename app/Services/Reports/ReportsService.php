<?php

namespace App\Services\Reports;

use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;

class ReportsService
{
    /**
     * Stock bajo: stock <= reorder_level.
     */
    public function lowStock(): Collection
    {
        return Product::query()
            ->with(['category', 'supplier'])
            ->lowStock()
            ->orderBy('stock')
            ->get();
    }

    /**
     * Más vendidos: sum(quantity) por producto con type=sale
     */
    public function mostSold(int $limit = 10): Collection
    {
        $rows = InventoryMovement::query()
            ->selectRaw('product_id, SUM(quantity) as total_sold')
            ->where('type', 'sale')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();

        $productIds = $rows->pluck('product_id')->all();

        $products = Product::query()
            ->whereIn('id', $productIds)
            ->with(['category', 'supplier'])
            ->get()
            ->keyBy('id');

        // Merge para que la resource pueda leer total_sold
        return $rows->map(function ($row) use ($products) {
            $product = $products->get((int) $row->product_id);
            if (! $product) {
                return null;
            }

            $product->setAttribute('total_sold', (int) $row->total_sold);
            return $product;
        })->filter();
    }

    public function recentMovements(int $limit = 20): Collection
    {
        return InventoryMovement::query()
            ->with(['product.category', 'user'])
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    public function inventorySummary(): Collection
    {
        return Product::query()
            ->with(['category', 'supplier'])
            ->orderBy('name')
            ->get();
    }

    /**
     * Reporte por categoría (stock actual por producto en esa categoría)
     */
    public function byCategory(?string $categoryId): Collection
    {
        $query = Product::query()
            ->with(['category', 'supplier'])
            ->orderBy('name');

        if (! empty($categoryId)) {
            $query->where('category_id', (int) $categoryId);
        }

        return $query->get();
    }
}

