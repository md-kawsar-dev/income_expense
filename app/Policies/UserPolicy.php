<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role_id, [1, 2]); // Admin and Manager
    }
    public function view(User $user, User $model): bool
    {
        return in_array($user->role_id, [1, 2]) || $user->id === $model->id;
    }
    public function create(User $user): bool
    {
        return in_array($user->role_id, [1, 2]); // Admin and Manager
    }
    public function update(User $user, User $model): bool
    {
        return in_array($user->role_id, [1, 2]) || $user->id === $model->id;
    }
    public function delete(User $user, User $model): bool
    {
        return in_array($user->role_id, [1,2]); // Only Admin
    }   
}