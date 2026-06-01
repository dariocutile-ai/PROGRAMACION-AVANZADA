<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->query()->orderBy('name')->get();
    }

    public function findWithRelations(int $id): Category
    {
        return $this->query()
            ->with(['products.supplier', 'comments.user'])
            ->findOrFail($id);
    }
}
