<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CashbackCounter;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashbackCounterPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CashbackCounter');
    }

    public function view(AuthUser $authUser, CashbackCounter $cashbackCounter): bool
    {
        return $authUser->can('View:CashbackCounter');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CashbackCounter');
    }

    public function update(AuthUser $authUser, CashbackCounter $cashbackCounter): bool
    {
        return $authUser->can('Update:CashbackCounter');
    }

    public function delete(AuthUser $authUser, CashbackCounter $cashbackCounter): bool
    {
        return $authUser->can('Delete:CashbackCounter');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CashbackCounter');
    }

    public function restore(AuthUser $authUser, CashbackCounter $cashbackCounter): bool
    {
        return $authUser->can('Restore:CashbackCounter');
    }

    public function forceDelete(AuthUser $authUser, CashbackCounter $cashbackCounter): bool
    {
        return $authUser->can('ForceDelete:CashbackCounter');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CashbackCounter');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CashbackCounter');
    }

    public function replicate(AuthUser $authUser, CashbackCounter $cashbackCounter): bool
    {
        return $authUser->can('Replicate:CashbackCounter');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CashbackCounter');
    }

}