<?php

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class KadrPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Kadr');
    }

    public function view(AuthUser $authUser): bool
    {
        return $authUser->can('View:Kadr');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Kadr');
    }

    public function update(AuthUser $authUser): bool
    {
        return $authUser->can('Update:Kadr');
    }

    public function delete(AuthUser $authUser): bool
    {
        return $authUser->can('Delete:Kadr');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Kadr');
    }

    public function restore(AuthUser $authUser): bool
    {
        return $authUser->can('Restore:Kadr');
    }

    public function forceDelete(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDelete:Kadr');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Kadr');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Kadr');
    }

    public function replicate(AuthUser $authUser): bool
    {
        return $authUser->can('Replicate:Kadr');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Kadr');
    }

}