<?php

namespace App\Repositories;

use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;

class SupplierRepository extends BaseRepository implements SupplierRepositoryInterface
{
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->query()->orderBy('name')->get();
    }

    public function findWithRelations(int $id): Supplier
    {
        return $this->query()
            ->with(['products.category', 'comments.user'])
            ->findOrFail($id);
    }
}
