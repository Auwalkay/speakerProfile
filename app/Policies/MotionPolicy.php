<?php

namespace App\Policies;

use App\Models\Motion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MotionPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability)
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Publisher', 'Editor', 'Viewer']);
    }

    public function view(User $user, Motion $motion): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Publisher', 'Editor', 'Viewer']);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create motions');
    }

    public function update(User $user, Motion $motion): bool
    {
        return $user->hasPermissionTo('edit motions');
    }

    public function delete(User $user, Motion $motion): bool
    {
        return $user->hasPermissionTo('delete motions');
    }

    public function publish(User $user, Motion $motion): bool
    {
        return $user->hasPermissionTo('publish motions');
    }
}
