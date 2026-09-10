<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\FailedRegistrationAttempt;
use Illuminate\Auth\Access\HandlesAuthorization;

class FailedRegistrationAttemptPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:FailedRegistrationAttempt');
    }

    public function view(AuthUser $authUser, FailedRegistrationAttempt $failedRegistrationAttempt): bool
    {
        return $authUser->can('View:FailedRegistrationAttempt');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FailedRegistrationAttempt');
    }

    public function update(AuthUser $authUser, FailedRegistrationAttempt $failedRegistrationAttempt): bool
    {
        return $authUser->can('Update:FailedRegistrationAttempt');
    }

    public function delete(AuthUser $authUser, FailedRegistrationAttempt $failedRegistrationAttempt): bool
    {
        return $authUser->can('Delete:FailedRegistrationAttempt');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:FailedRegistrationAttempt');
    }

    public function restore(AuthUser $authUser, FailedRegistrationAttempt $failedRegistrationAttempt): bool
    {
        return $authUser->can('Restore:FailedRegistrationAttempt');
    }

    public function forceDelete(AuthUser $authUser, FailedRegistrationAttempt $failedRegistrationAttempt): bool
    {
        return $authUser->can('ForceDelete:FailedRegistrationAttempt');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FailedRegistrationAttempt');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FailedRegistrationAttempt');
    }

    public function replicate(AuthUser $authUser, FailedRegistrationAttempt $failedRegistrationAttempt): bool
    {
        return $authUser->can('Replicate:FailedRegistrationAttempt');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FailedRegistrationAttempt');
    }

}