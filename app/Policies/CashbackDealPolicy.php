<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CashbackDeal;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashbackDealPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CashbackDeal');
    }

    public function view(AuthUser $authUser, CashbackDeal $cashbackDeal): bool
    {
        return $authUser->can('View:CashbackDeal');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CashbackDeal');
    }

    public function update(AuthUser $authUser, CashbackDeal $cashbackDeal): bool
    {
        return $authUser->can('Update:CashbackDeal');
    }

    public function delete(AuthUser $authUser, CashbackDeal $cashbackDeal): bool
    {
        return $authUser->can('Delete:CashbackDeal');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CashbackDeal');
    }

    public function restore(AuthUser $authUser, CashbackDeal $cashbackDeal): bool
    {
        return $authUser->can('Restore:CashbackDeal');
    }

    public function forceDelete(AuthUser $authUser, CashbackDeal $cashbackDeal): bool
    {
        return $authUser->can('ForceDelete:CashbackDeal');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CashbackDeal');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CashbackDeal');
    }

    public function replicate(AuthUser $authUser, CashbackDeal $cashbackDeal): bool
    {
        return $authUser->can('Replicate:CashbackDeal');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CashbackDeal');
    }

}