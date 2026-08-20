<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CompanyFund;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyFundPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CompanyFund');
    }

    public function view(AuthUser $authUser, CompanyFund $companyFund): bool
    {
        return $authUser->can('View:CompanyFund');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CompanyFund');
    }

    public function update(AuthUser $authUser, CompanyFund $companyFund): bool
    {
        return $authUser->can('Update:CompanyFund');
    }

    public function delete(AuthUser $authUser, CompanyFund $companyFund): bool
    {
        return $authUser->can('Delete:CompanyFund');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CompanyFund');
    }

    public function restore(AuthUser $authUser, CompanyFund $companyFund): bool
    {
        return $authUser->can('Restore:CompanyFund');
    }

    public function forceDelete(AuthUser $authUser, CompanyFund $companyFund): bool
    {
        return $authUser->can('ForceDelete:CompanyFund');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CompanyFund');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CompanyFund');
    }

    public function replicate(AuthUser $authUser, CompanyFund $companyFund): bool
    {
        return $authUser->can('Replicate:CompanyFund');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CompanyFund');
    }

}