<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ApplyJob;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplyJobPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ApplyJob');
    }

    public function view(AuthUser $authUser, ApplyJob $applyJob): bool
    {
        return $authUser->can('View:ApplyJob');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ApplyJob');
    }

    public function update(AuthUser $authUser, ApplyJob $applyJob): bool
    {
        return $authUser->can('Update:ApplyJob');
    }

    public function delete(AuthUser $authUser, ApplyJob $applyJob): bool
    {
        return $authUser->can('Delete:ApplyJob');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ApplyJob');
    }

    public function restore(AuthUser $authUser, ApplyJob $applyJob): bool
    {
        return $authUser->can('Restore:ApplyJob');
    }

    public function forceDelete(AuthUser $authUser, ApplyJob $applyJob): bool
    {
        return $authUser->can('ForceDelete:ApplyJob');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ApplyJob');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ApplyJob');
    }

    public function replicate(AuthUser $authUser, ApplyJob $applyJob): bool
    {
        return $authUser->can('Replicate:ApplyJob');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ApplyJob');
    }

}