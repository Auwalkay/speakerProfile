<?php

namespace App\Policies;

use App\Models\ConstituencyProject;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConstituencyProjectPolicy
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

    public function view(User $user, ConstituencyProject $project): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Publisher', 'Editor', 'Viewer']);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create projects');
    }

    public function update(User $user, ConstituencyProject $project): bool
    {
        return $user->hasPermissionTo('edit projects');
    }

    public function delete(User $user, ConstituencyProject $project): bool
    {
        return $user->hasPermissionTo('delete projects');
    }

    public function publish(User $user, ConstituencyProject $project): bool
    {
        return $user->hasPermissionTo('publish projects');
    }
}
