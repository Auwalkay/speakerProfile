<?php

namespace App\Policies;

use App\Models\LegislativeWork;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LegislativeWorkPolicy
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

    public function view(User $user, LegislativeWork $work): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Publisher', 'Editor', 'Viewer']);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create achievements'); // Mapped to general content privileges
    }

    public function update(User $user, LegislativeWork $work): bool
    {
        return $user->hasPermissionTo('edit achievements');
    }

    public function delete(User $user, LegislativeWork $work): bool
    {
        return $user->hasPermissionTo('delete achievements');
    }

    public function publish(User $user, LegislativeWork $work): bool
    {
        return $user->hasPermissionTo('publish achievements');
    }
}
