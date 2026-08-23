<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
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

    public function view(User $user, News $news): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Publisher', 'Editor', 'Viewer']);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create news');
    }

    public function update(User $user, News $news): bool
    {
        return $user->hasPermissionTo('edit news');
    }

    public function delete(User $user, News $news): bool
    {
        return $user->hasPermissionTo('delete news');
    }

    public function publish(User $user, News $news): bool
    {
        return $user->hasPermissionTo('publish news');
    }
}
