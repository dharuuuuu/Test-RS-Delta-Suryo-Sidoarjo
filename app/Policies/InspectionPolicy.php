<?php

namespace App\Policies;

use App\Models\Inspection;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InspectionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list inspections');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view inspections');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create inspections');
    }

    public function update(User $user, Inspection $model): bool
    {
        return $user->hasPermissionTo('update inspections');
    }

    public function delete(User $user, Inspection $model): bool
    {
        return $user->hasPermissionTo('delete inspections');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete inspections');
    }

    public function restore(User $user, Inspection $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Inspection $model): bool
    {
        return false;
    }
}
