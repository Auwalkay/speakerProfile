<?php

namespace App\Policies;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AchievementPolicy
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

    public function view(User $user, Achievement $achievement): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Publisher', 'Editor', 'Viewer']);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create achievements');
    }

    public function update(User $user, Achievement $achievement): bool
    {
        return $user->hasPermissionTo('edit achievements');
    }

    public function delete(User $user, Achievement $achievement): bool
    {
        return $user->hasPermissionTo('delete achievements');
    }

    public function publish(User $user, Achievement $achievement): bool
    {
        return $user->hasPermissionTo('publish achievements');
    }
}
