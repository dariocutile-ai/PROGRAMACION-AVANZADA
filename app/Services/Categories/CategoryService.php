<?php

namespace App\Services\Categories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function __construct(private readonly CategoryRepositoryInterface $repository) {}

    public function index(): Collection
    {
        return $this->repository->all();
    }

    public function show(int $category): Category
    {
        return $this->repository->findWithRelations($category);
    }

    public function create(array $data): Category
    {
        return $this->repository->create($data);
    }

    public function update(int $category, array $data): Category
    {
        return $this->repository->update($category, $data);
    }

    public function delete(int $category): void
    {
        $this->repository->delete($category);
    }
}

