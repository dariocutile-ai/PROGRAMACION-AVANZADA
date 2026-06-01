<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    public function all(): Collection
    {
        return $this->query()->get();
    }

    public function findOrFail(int $id): Model
    {
        return $this->query()->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->query()->create($data);
    }

    public function update(int $id, array $data): Model
    {
        $model = $this->findOrFail($id);
        $model->update($data);

        return $model;
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }
}
