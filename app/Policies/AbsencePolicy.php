<?php

namespace App\Policies;

use App\Models\Absence;
use App\Models\Annee;
use App\Models\User;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Auth\Access\HandlesAuthorization;

class AbsencePolicy
{
    use HandlesAuthorization;
    use InteractsWithPageFilters;

    protected static ?Annee $annee = null;
    public function __construct()
    {
        self::$annee = Annee::whereSlug($filters['annee_id'] ?? now()->year)->firstOrFail();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_absence');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Absence $absence): bool
    {
        return $user->can('view_absence');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_absence') && self::$annee->hasStatutEnCours();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Absence $absence): bool
    {
        return $user->can('update_absence');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Absence $absence): bool
    {
        return $user->can('delete_absence');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_absence');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Absence $absence): bool
    {
        return $user->can('force_delete_absence');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_absence');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Absence $absence): bool
    {
        return $user->can('restore_absence');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_absence');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Absence $absence): bool
    {
        return $user->can('replicate_absence');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_absence');
    }
}
