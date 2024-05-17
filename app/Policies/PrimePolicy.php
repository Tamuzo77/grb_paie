<?php

namespace App\Policies;

use App\Models\Prime;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrimePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_prime');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Prime $prime): bool
    {
        return $user->can('view_prime');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_prime') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Prime $prime): bool
    {
        return $user->can('update_prime') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Prime $prime): bool
    {
        return $user->can('delete_prime') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_prime') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Prime $prime): bool
    {
        return $user->can('force_delete_prime') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_prime') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Prime $prime): bool
    {
        return $user->can('restore_prime') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_prime') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Prime $prime): bool
    {
        return $user->can('replicate_prime') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_prime') && getAnnee()->hasStatutEnCours();
    }
}
