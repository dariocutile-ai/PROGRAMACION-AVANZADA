<?php

namespace App\Policies;

use App\Models\InventoryMovement;
use App\Models\User;
use App\Policies\Concerns\ChecksRoles;

class InventoryMovementPolicy
{
    use ChecksRoles;

    public function viewAny(User $user): bool
    {
        return $this->any($user, ['Admin', 'Manager', 'Employee']);
    }

    public function view(User $user, InventoryMovement $movement): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->any($user, ['Admin', 'Manager']);
    }
}
