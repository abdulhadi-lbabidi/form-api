<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CompanyFeedback;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyFeedbackPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CompanyFeedback');
    }

    public function view(AuthUser $authUser, CompanyFeedback $companyFeedback): bool
    {
        return $authUser->can('View:CompanyFeedback');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CompanyFeedback');
    }

    public function update(AuthUser $authUser, CompanyFeedback $companyFeedback): bool
    {
        return $authUser->can('Update:CompanyFeedback');
    }

    public function delete(AuthUser $authUser, CompanyFeedback $companyFeedback): bool
    {
        return $authUser->can('Delete:CompanyFeedback');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CompanyFeedback');
    }

    public function restore(AuthUser $authUser, CompanyFeedback $companyFeedback): bool
    {
        return $authUser->can('Restore:CompanyFeedback');
    }

    public function forceDelete(AuthUser $authUser, CompanyFeedback $companyFeedback): bool
    {
        return $authUser->can('ForceDelete:CompanyFeedback');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CompanyFeedback');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CompanyFeedback');
    }

    public function replicate(AuthUser $authUser, CompanyFeedback $companyFeedback): bool
    {
        return $authUser->can('Replicate:CompanyFeedback');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CompanyFeedback');
    }

}