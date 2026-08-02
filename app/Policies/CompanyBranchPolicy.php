<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CompanyBranch;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyBranchPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CompanyBranch');
    }

    public function view(AuthUser $authUser, CompanyBranch $companyBranch): bool
    {
        return $authUser->can('View:CompanyBranch');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CompanyBranch');
    }

    public function update(AuthUser $authUser, CompanyBranch $companyBranch): bool
    {
        return $authUser->can('Update:CompanyBranch');
    }

    public function delete(AuthUser $authUser, CompanyBranch $companyBranch): bool
    {
        return $authUser->can('Delete:CompanyBranch');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CompanyBranch');
    }

    public function restore(AuthUser $authUser, CompanyBranch $companyBranch): bool
    {
        return $authUser->can('Restore:CompanyBranch');
    }

    public function forceDelete(AuthUser $authUser, CompanyBranch $companyBranch): bool
    {
        return $authUser->can('ForceDelete:CompanyBranch');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CompanyBranch');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CompanyBranch');
    }

    public function replicate(AuthUser $authUser, CompanyBranch $companyBranch): bool
    {
        return $authUser->can('Replicate:CompanyBranch');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CompanyBranch');
    }

}