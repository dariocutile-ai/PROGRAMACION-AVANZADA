<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function list(array $filters, array $sort): LengthAwarePaginator
    {
        $query = $this->query()->with(['category', 'supplier', 'comments']);

        if (!empty($filters['q'])) {
            $search = (string) $filters['q'];

            $query->where(function (Builder $query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', (int) $filters['category_id']);
        }

        if (!empty($filters['supplier_id'])) {
            $query->where('supplier_id', (int) $filters['supplier_id']);
        }

        // Ordenamiento seguro
        $allowedSorts = [
            'id',
            'name',
            'sku',
            'stock',
            'sale_price',
            'created_at',
        ];

        $sortField = $sort['sort'] ?? 'id';
        $sortOrder = $sort['order'] ?? 'desc';

        if (!in_array($sortField, $allowedSorts, true)) {
            $sortField = 'id';
        }

        if (!in_array($sortOrder, ['asc', 'desc'], true)) {
            $sortOrder = 'desc';
        }

        return $query
            ->orderBy($sortField, $sortOrder)
            ->paginate(15);
    }

    public function findWithRelations(int $id): Product
    {
        return $this->query()
            ->with([
                'category',
                'supplier',
                'inventoryMovements.user',
                'comments.user',
            ])
            ->findOrFail($id);
    }
}
