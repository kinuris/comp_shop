<?php

namespace App\Policies;

use App\Models\Discount;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DiscountPolicy
{
    public function viewAny(User $user = null): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user = null, Discount $discount = null): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Discount $discount = null): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Discount $discount = null): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Discount $discount = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Discount $discount = null): bool
    {
        return $user->isAdmin();
    }
}
