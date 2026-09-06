<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\WorkerFeedback;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkerFeedbackPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:WorkerFeedback');
    }

    public function view(AuthUser $authUser, WorkerFeedback $workerFeedback): bool
    {
        return $authUser->can('View:WorkerFeedback');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:WorkerFeedback');
    }

    public function update(AuthUser $authUser, WorkerFeedback $workerFeedback): bool
    {
        return $authUser->can('Update:WorkerFeedback');
    }

    public function delete(AuthUser $authUser, WorkerFeedback $workerFeedback): bool
    {
        return $authUser->can('Delete:WorkerFeedback');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:WorkerFeedback');
    }

    public function restore(AuthUser $authUser, WorkerFeedback $workerFeedback): bool
    {
        return $authUser->can('Restore:WorkerFeedback');
    }

    public function forceDelete(AuthUser $authUser, WorkerFeedback $workerFeedback): bool
    {
        return $authUser->can('ForceDelete:WorkerFeedback');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:WorkerFeedback');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:WorkerFeedback');
    }

    public function replicate(AuthUser $authUser, WorkerFeedback $workerFeedback): bool
    {
        return $authUser->can('Replicate:WorkerFeedback');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:WorkerFeedback');
    }

}