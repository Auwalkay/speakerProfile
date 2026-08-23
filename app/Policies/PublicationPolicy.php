<?php

namespace App\Policies;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PublicationPolicy
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

    public function view(User $user, Publication $publication): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Publisher', 'Editor', 'Viewer']);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create publications');
    }

    public function update(User $user, Publication $publication): bool
    {
        return $user->hasPermissionTo('edit publications');
    }

    public function delete(User $user, Publication $publication): bool
    {
        return $user->hasPermissionTo('delete publications');
    }

    public function publish(User $user, Publication $publication): bool
    {
        return $user->hasPermissionTo('publish publications');
    }
}
