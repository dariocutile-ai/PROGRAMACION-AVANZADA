<?php

namespace App\Interfaces;

use App\Models\Category;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;

    public function findWithRelations(int $id): Category;
}
