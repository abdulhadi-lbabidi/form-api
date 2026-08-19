<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KadrNeed;
use Illuminate\Auth\Access\HandlesAuthorization;

class KadrNeedPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KadrNeed');
    }

    public function view(AuthUser $authUser, KadrNeed $kadrNeed): bool
    {
        return $authUser->can('View:KadrNeed');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KadrNeed');
    }

    public function update(AuthUser $authUser, KadrNeed $kadrNeed): bool
    {
        return $authUser->can('Update:KadrNeed');
    }

    public function delete(AuthUser $authUser, KadrNeed $kadrNeed): bool
    {
        return $authUser->can('Delete:KadrNeed');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KadrNeed');
    }

    public function restore(AuthUser $authUser, KadrNeed $kadrNeed): bool
    {
        return $authUser->can('Restore:KadrNeed');
    }

    public function forceDelete(AuthUser $authUser, KadrNeed $kadrNeed): bool
    {
        return $authUser->can('ForceDelete:KadrNeed');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KadrNeed');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KadrNeed');
    }

    public function replicate(AuthUser $authUser, KadrNeed $kadrNeed): bool
    {
        return $authUser->can('Replicate:KadrNeed');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KadrNeed');
    }

}