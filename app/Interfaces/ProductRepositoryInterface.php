<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Product;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function list(array $filters, array $sort): LengthAwarePaginator;

    public function findWithRelations(int $id): Product;
}
