<?php

namespace App\Repositories;

use App\Interfaces\InventoryMovementRepositoryInterface;
use App\Models\InventoryMovement;

class InventoryMovementRepository extends BaseRepository implements InventoryMovementRepositoryInterface
{
    public function __construct(InventoryMovement $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): InventoryMovement
    {
        return $this->query()->create($data);
    }
}
