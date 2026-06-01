<?php

namespace App\Services\Suppliers;

use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;

class SupplierService
{
    public function __construct(private readonly SupplierRepositoryInterface $repository) {}

    public function index(): Collection
    {
        return $this->repository->all();
    }

    public function show(int $supplier): Supplier
    {
        return $this->repository->findWithRelations($supplier);
    }

    public function create(array $data): Supplier
    {
        return $this->repository->create($data);
    }

    public function update(int $supplier, array $data): Supplier
    {
        return $this->repository->update($supplier, $data);
    }

    public function delete(int $supplier): void
    {
        $this->repository->delete($supplier);
    }
}

