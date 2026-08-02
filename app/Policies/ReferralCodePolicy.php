<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ReferralCode;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReferralCodePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ReferralCode');
    }

    public function view(AuthUser $authUser, ReferralCode $referralCode): bool
    {
        return $authUser->can('View:ReferralCode');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ReferralCode');
    }

    public function update(AuthUser $authUser, ReferralCode $referralCode): bool
    {
        return $authUser->can('Update:ReferralCode');
    }

    public function delete(AuthUser $authUser, ReferralCode $referralCode): bool
    {
        return $authUser->can('Delete:ReferralCode');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ReferralCode');
    }

    public function restore(AuthUser $authUser, ReferralCode $referralCode): bool
    {
        return $authUser->can('Restore:ReferralCode');
    }

    public function forceDelete(AuthUser $authUser, ReferralCode $referralCode): bool
    {
        return $authUser->can('ForceDelete:ReferralCode');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ReferralCode');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ReferralCode');
    }

    public function replicate(AuthUser $authUser, ReferralCode $referralCode): bool
    {
        return $authUser->can('Replicate:ReferralCode');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ReferralCode');
    }

}