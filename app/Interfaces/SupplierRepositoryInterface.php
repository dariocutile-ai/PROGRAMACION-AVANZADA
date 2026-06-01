<?php

namespace App\Interfaces;

use App\Models\Supplier;

interface SupplierRepositoryInterface extends RepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;

    public function findWithRelations(int $id): Supplier;
}
