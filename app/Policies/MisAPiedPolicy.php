<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MisAPied;
use Illuminate\Auth\Access\HandlesAuthorization;

class MisAPiedPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_mis::a::pied');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MisAPied $misAPied): bool
    {
        return $user->can('view_mis::a::pied');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_mis::a::pied') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MisAPied $misAPied): bool
    {
        return $user->can('update_mis::a::pied') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MisAPied $misAPied): bool
    {
        return $user->can('delete_mis::a::pied') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_mis::a::pied') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, MisAPied $misAPied): bool
    {
        return $user->can('force_delete_mis::a::pied') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_mis::a::pied') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, MisAPied $misAPied): bool
    {
        return $user->can('restore_mis::a::pied') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_mis::a::pied') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, MisAPied $misAPied): bool
    {
        return $user->can('replicate_mis::a::pied') && getAnnee()->hasStatutEnCours();
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_mis::a::pied') && getAnnee()->hasStatutEnCours();
    }
}
