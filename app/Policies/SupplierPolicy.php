<?php

namespace App\Policies;

use App\Models\Supplier;
use App\Models\User;
use App\Policies\Concerns\ChecksRoles;

class SupplierPolicy
{
    use ChecksRoles;

    public function viewAny(User $user): bool
    {
        return $this->any($user, ['Admin', 'Manager', 'Employee']);
    }

    public function view(User $user, Supplier $supplier): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->any($user, ['Admin']);
    }

    public function update(User $user, Supplier $supplier): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, Supplier $supplier): bool
    {
        return $this->create($user);
    }
}
