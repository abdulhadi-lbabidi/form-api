<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AccountUpgraded;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountUpgradedPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AccountUpgraded');
    }

    public function view(AuthUser $authUser, AccountUpgraded $accountUpgraded): bool
    {
        return $authUser->can('View:AccountUpgraded');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AccountUpgraded');
    }

    public function update(AuthUser $authUser, AccountUpgraded $accountUpgraded): bool
    {
        return $authUser->can('Update:AccountUpgraded');
    }

    public function delete(AuthUser $authUser, AccountUpgraded $accountUpgraded): bool
    {
        return $authUser->can('Delete:AccountUpgraded');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:AccountUpgraded');
    }

    public function restore(AuthUser $authUser, AccountUpgraded $accountUpgraded): bool
    {
        return $authUser->can('Restore:AccountUpgraded');
    }

    public function forceDelete(AuthUser $authUser, AccountUpgraded $accountUpgraded): bool
    {
        return $authUser->can('ForceDelete:AccountUpgraded');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AccountUpgraded');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AccountUpgraded');
    }

    public function replicate(AuthUser $authUser, AccountUpgraded $accountUpgraded): bool
    {
        return $authUser->can('Replicate:AccountUpgraded');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AccountUpgraded');
    }

}