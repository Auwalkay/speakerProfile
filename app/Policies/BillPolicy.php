<?php

namespace App\Policies;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BillPolicy
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

    public function view(User $user, Bill $bill): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Publisher', 'Editor', 'Viewer']);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create bills');
    }

    public function update(User $user, Bill $bill): bool
    {
        return $user->hasPermissionTo('edit bills');
    }

    public function delete(User $user, Bill $bill): bool
    {
        return $user->hasPermissionTo('delete bills');
    }

    public function publish(User $user, Bill $bill): bool
    {
        return $user->hasPermissionTo('publish bills');
    }
}
