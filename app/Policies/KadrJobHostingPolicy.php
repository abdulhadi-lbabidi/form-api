<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KadrJobHosting;
use Illuminate\Auth\Access\HandlesAuthorization;

class KadrJobHostingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KadrJobHosting');
    }

    public function view(AuthUser $authUser, KadrJobHosting $kadrJobHosting): bool
    {
        return $authUser->can('View:KadrJobHosting');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KadrJobHosting');
    }

    public function update(AuthUser $authUser, KadrJobHosting $kadrJobHosting): bool
    {
        return $authUser->can('Update:KadrJobHosting');
    }

    public function delete(AuthUser $authUser, KadrJobHosting $kadrJobHosting): bool
    {
        return $authUser->can('Delete:KadrJobHosting');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KadrJobHosting');
    }

    public function restore(AuthUser $authUser, KadrJobHosting $kadrJobHosting): bool
    {
        return $authUser->can('Restore:KadrJobHosting');
    }

    public function forceDelete(AuthUser $authUser, KadrJobHosting $kadrJobHosting): bool
    {
        return $authUser->can('ForceDelete:KadrJobHosting');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KadrJobHosting');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KadrJobHosting');
    }

    public function replicate(AuthUser $authUser, KadrJobHosting $kadrJobHosting): bool
    {
        return $authUser->can('Replicate:KadrJobHosting');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KadrJobHosting');
    }

}