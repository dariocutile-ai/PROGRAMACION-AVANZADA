<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use App\Policies\Concerns\ChecksRoles;

class ReportPolicy
{
    use ChecksRoles;

    public function viewAny(User $user): bool
    {
        return $this->any($user, ['Admin', 'Manager', 'Employee']);
    }

    public function view(User $user, Report $report): bool
    {
        return $this->viewAny($user);
    }
}
