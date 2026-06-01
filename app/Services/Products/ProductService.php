<?php

namespace App\Services\Products;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductService
{
    public function __construct(private readonly ProductRepositoryInterface $repository) {}

    public function list(array $filters, array $sort)
    {
        return $this->repository->list($filters, $sort);
    }

    public function create(array $data): Product
    {
        return $this->repository->create($data);
    }

    public function getById(int $id): Product
    {
        return $this->repository->findWithRelations($id);
    }

    public function update(int $id, array $data): Product
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}

