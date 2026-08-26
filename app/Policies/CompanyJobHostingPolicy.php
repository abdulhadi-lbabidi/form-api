<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CompanyJobHosting;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyJobHostingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CompanyJobHosting');
    }

    public function view(AuthUser $authUser, CompanyJobHosting $companyJobHosting): bool
    {
        return $authUser->can('View:CompanyJobHosting');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CompanyJobHosting');
    }

    public function update(AuthUser $authUser, CompanyJobHosting $companyJobHosting): bool
    {
        return $authUser->can('Update:CompanyJobHosting');
    }

    public function delete(AuthUser $authUser, CompanyJobHosting $companyJobHosting): bool
    {
        return $authUser->can('Delete:CompanyJobHosting');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CompanyJobHosting');
    }

    public function restore(AuthUser $authUser, CompanyJobHosting $companyJobHosting): bool
    {
        return $authUser->can('Restore:CompanyJobHosting');
    }

    public function forceDelete(AuthUser $authUser, CompanyJobHosting $companyJobHosting): bool
    {
        return $authUser->can('ForceDelete:CompanyJobHosting');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CompanyJobHosting');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CompanyJobHosting');
    }

    public function replicate(AuthUser $authUser, CompanyJobHosting $companyJobHosting): bool
    {
        return $authUser->can('Replicate:CompanyJobHosting');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CompanyJobHosting');
    }

}