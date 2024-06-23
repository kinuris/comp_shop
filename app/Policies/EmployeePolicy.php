<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmployeePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, User $model = null): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $model = null): bool
    {
        if ($model->isAdmin()) {
            return false;
        }

        return $user->isAdmin();
    }

    public function delete(User $user, User $model = null): bool
    {
        if ($model->isAdmin()) {
            return false;
        }

        return $user->isAdmin();
    }

    public function restore(User $user, User $model = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, User $model = null): bool
    {
        return $user->isAdmin();
    }
}
