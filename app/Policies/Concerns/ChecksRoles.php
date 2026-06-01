<?php

namespace App\Policies\Concerns;

use App\Models\User;

trait ChecksRoles
{
    private function any(User $user, array $roles): bool
    {
        $user->loadMissing('roles');

        return $user->hasAnyRole($roles);
    }
}
