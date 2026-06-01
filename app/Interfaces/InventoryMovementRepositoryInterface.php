<?php

namespace App\Interfaces;

use App\Models\InventoryMovement;

interface InventoryMovementRepositoryInterface extends RepositoryInterface
{
    public function create(array $data): InventoryMovement;
}
