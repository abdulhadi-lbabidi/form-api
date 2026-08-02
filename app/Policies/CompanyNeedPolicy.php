<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CompanyNeed;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyNeedPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CompanyNeed');
    }

    public function view(AuthUser $authUser, CompanyNeed $companyNeed): bool
    {
        return $authUser->can('View:CompanyNeed');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CompanyNeed');
    }

    public function update(AuthUser $authUser, CompanyNeed $companyNeed): bool
    {
        return $authUser->can('Update:CompanyNeed');
    }

    public function delete(AuthUser $authUser, CompanyNeed $companyNeed): bool
    {
        return $authUser->can('Delete:CompanyNeed');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CompanyNeed');
    }

    public function restore(AuthUser $authUser, CompanyNeed $companyNeed): bool
    {
        return $authUser->can('Restore:CompanyNeed');
    }

    public function forceDelete(AuthUser $authUser, CompanyNeed $companyNeed): bool
    {
        return $authUser->can('ForceDelete:CompanyNeed');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CompanyNeed');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CompanyNeed');
    }

    public function replicate(AuthUser $authUser, CompanyNeed $companyNeed): bool
    {
        return $authUser->can('Replicate:CompanyNeed');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CompanyNeed');
    }

}