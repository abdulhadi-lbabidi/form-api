<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CashbackCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashbackCategoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CashbackCategory');
    }

    public function view(AuthUser $authUser, CashbackCategory $cashbackCategory): bool
    {
        return $authUser->can('View:CashbackCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CashbackCategory');
    }

    public function update(AuthUser $authUser, CashbackCategory $cashbackCategory): bool
    {
        return $authUser->can('Update:CashbackCategory');
    }

    public function delete(AuthUser $authUser, CashbackCategory $cashbackCategory): bool
    {
        return $authUser->can('Delete:CashbackCategory');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CashbackCategory');
    }

    public function restore(AuthUser $authUser, CashbackCategory $cashbackCategory): bool
    {
        return $authUser->can('Restore:CashbackCategory');
    }

    public function forceDelete(AuthUser $authUser, CashbackCategory $cashbackCategory): bool
    {
        return $authUser->can('ForceDelete:CashbackCategory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CashbackCategory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CashbackCategory');
    }

    public function replicate(AuthUser $authUser, CashbackCategory $cashbackCategory): bool
    {
        return $authUser->can('Replicate:CashbackCategory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CashbackCategory');
    }

}