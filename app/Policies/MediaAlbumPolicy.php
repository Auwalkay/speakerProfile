<?php

namespace App\Policies;

use App\Models\MediaAlbum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaAlbumPolicy
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

    public function view(User $user, MediaAlbum $album): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Publisher', 'Editor', 'Viewer']);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create media');
    }

    public function update(User $user, MediaAlbum $album): bool
    {
        return $user->hasPermissionTo('edit media');
    }

    public function delete(User $user, MediaAlbum $album): bool
    {
        return $user->hasPermissionTo('delete media');
    }

    public function publish(User $user, MediaAlbum $album): bool
    {
        return $user->hasPermissionTo('publish media');
    }
}
