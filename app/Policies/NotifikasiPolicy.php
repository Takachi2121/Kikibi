<?php

namespace App\Policies;

use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotifikasiPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Notifikasi $notifikasi): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Notifikasi $notifikasi): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Notifikasi $notifikasi): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Notifikasi $notifikasi): bool
    {
        return false;
    }
}
