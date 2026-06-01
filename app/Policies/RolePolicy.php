<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Policies\Concerns\ChecksRoles;

class RolePolicy
{
    use ChecksRoles;

    public function viewAny(User $user): bool
    {
        return $this->any($user, ['Admin']);
    }

    public function view(User $user, Role $role): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, Role $role): bool
    {
        return $this->viewAny($user);
    }

    public function delete(User $user, Role $role): bool
    {
        return $this->viewAny($user) && ! in_array($role->name, ['Admin', 'Manager', 'Employee'], true);
    }
}
