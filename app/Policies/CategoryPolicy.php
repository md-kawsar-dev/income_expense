<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    protected function hasRole(User $user, array $roles): bool
    {
        return in_array($user->role_id, $roles);
    }
    public function viewAny(User $user): bool
    {
        return $this->hasRole($user, [1, 2,3,4]);
    }
    public function view(User $user,Category $category): bool
    {
        return $this->hasRole($user, [1, 2,3,4]);
    }
    public function create(User $user): bool
    {
        return $this->hasRole($user, [1, 2]); // Admin and Manager
    }
    public function update(User $user,Category $category): bool
    {
        return $this->hasRole($user, [1, 2,3]);
    }
    public function delete(User $user,Category $category): bool
    {
        return $this->hasRole($user, [1,2]); // Only Admin
    }

}
