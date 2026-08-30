<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AccountUpgradeRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountUpgradeRequestPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AccountUpgradeRequest');
    }

    public function view(AuthUser $authUser, AccountUpgradeRequest $accountUpgradeRequest): bool
    {
        return $authUser->can('View:AccountUpgradeRequest');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AccountUpgradeRequest');
    }

    public function update(AuthUser $authUser, AccountUpgradeRequest $accountUpgradeRequest): bool
    {
        return $authUser->can('Update:AccountUpgradeRequest');
    }

    public function delete(AuthUser $authUser, AccountUpgradeRequest $accountUpgradeRequest): bool
    {
        return $authUser->can('Delete:AccountUpgradeRequest');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:AccountUpgradeRequest');
    }

    public function restore(AuthUser $authUser, AccountUpgradeRequest $accountUpgradeRequest): bool
    {
        return $authUser->can('Restore:AccountUpgradeRequest');
    }

    public function forceDelete(AuthUser $authUser, AccountUpgradeRequest $accountUpgradeRequest): bool
    {
        return $authUser->can('ForceDelete:AccountUpgradeRequest');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AccountUpgradeRequest');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AccountUpgradeRequest');
    }

    public function replicate(AuthUser $authUser, AccountUpgradeRequest $accountUpgradeRequest): bool
    {
        return $authUser->can('Replicate:AccountUpgradeRequest');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AccountUpgradeRequest');
    }

}