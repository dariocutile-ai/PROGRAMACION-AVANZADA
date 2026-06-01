<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use App\Policies\Concerns\ChecksRoles;

class CategoryPolicy
{
    use ChecksRoles;

    public function viewAny(User $user): bool
    {
        return $this->any($user, ['Admin', 'Manager', 'Employee']);
    }

    public function view(User $user, Category $category): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->any($user, ['Admin']);
    }

    public function update(User $user, Category $category): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, Category $category): bool
    {
        return $this->create($user);
    }
}
