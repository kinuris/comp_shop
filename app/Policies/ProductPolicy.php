<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function process(User $user): bool
    {
        return $user->isEmployee();
    }

    public function viewAny(User $user): bool
    {
        return $user->isManager() || $user->isAdmin();
    }

    public function view(User $user, ?Product $product = null): bool
    {
        return $user->isManager() || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isManager() || $user->isAdmin();
    }

    public function update(User $user, Product $product = null): bool
    {
        return $user->isManager() || $user->isAdmin();
    }

    public function delete(User $user, Product $product = null): bool
    {
        return $user->isManager() || $user->isAdmin();
    }

    public function restore(User $user, Product $product = null): bool
    {
        return $user->isManager() || $user->isAdmin();
    }

    public function forceDelete(User $user, Product $product = null): bool
    {
        return $user->isManager() || $user->isAdmin();
    }
}
