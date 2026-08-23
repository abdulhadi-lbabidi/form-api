<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Cashback;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashbackPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Cashback');
    }

    public function view(AuthUser $authUser, Cashback $cashback): bool
    {
        return $authUser->can('View:Cashback');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Cashback');
    }

    public function update(AuthUser $authUser, Cashback $cashback): bool
    {
        return $authUser->can('Update:Cashback');
    }

    public function delete(AuthUser $authUser, Cashback $cashback): bool
    {
        return $authUser->can('Delete:Cashback');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Cashback');
    }

    public function restore(AuthUser $authUser, Cashback $cashback): bool
    {
        return $authUser->can('Restore:Cashback');
    }

    public function forceDelete(AuthUser $authUser, Cashback $cashback): bool
    {
        return $authUser->can('ForceDelete:Cashback');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Cashback');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Cashback');
    }

    public function replicate(AuthUser $authUser, Cashback $cashback): bool
    {
        return $authUser->can('Replicate:Cashback');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Cashback');
    }

}