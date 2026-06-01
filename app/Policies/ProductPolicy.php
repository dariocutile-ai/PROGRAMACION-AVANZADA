<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use App\Policies\Concerns\ChecksRoles;

class ProductPolicy
{
    use ChecksRoles;

    public function viewAny(User $user): bool
    {
        return $this->any($user, ['Admin', 'Manager', 'Employee']);
    }

    public function view(User $user, Product $product): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->any($user, ['Admin', 'Manager']);
    }

    public function update(User $user, Product $product): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, Product $product): bool
    {
        return $this->any($user, ['Admin']);
    }
}
