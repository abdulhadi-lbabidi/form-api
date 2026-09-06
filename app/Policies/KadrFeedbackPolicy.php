<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KadrFeedback;
use Illuminate\Auth\Access\HandlesAuthorization;

class KadrFeedbackPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KadrFeedback');
    }

    public function view(AuthUser $authUser, KadrFeedback $kadrFeedback): bool
    {
        return $authUser->can('View:KadrFeedback');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KadrFeedback');
    }

    public function update(AuthUser $authUser, KadrFeedback $kadrFeedback): bool
    {
        return $authUser->can('Update:KadrFeedback');
    }

    public function delete(AuthUser $authUser, KadrFeedback $kadrFeedback): bool
    {
        return $authUser->can('Delete:KadrFeedback');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KadrFeedback');
    }

    public function restore(AuthUser $authUser, KadrFeedback $kadrFeedback): bool
    {
        return $authUser->can('Restore:KadrFeedback');
    }

    public function forceDelete(AuthUser $authUser, KadrFeedback $kadrFeedback): bool
    {
        return $authUser->can('ForceDelete:KadrFeedback');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KadrFeedback');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KadrFeedback');
    }

    public function replicate(AuthUser $authUser, KadrFeedback $kadrFeedback): bool
    {
        return $authUser->can('Replicate:KadrFeedback');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KadrFeedback');
    }

}