<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MarketingSource;
use Illuminate\Auth\Access\HandlesAuthorization;

class MarketingSourcePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MarketingSource');
    }

    public function view(AuthUser $authUser, MarketingSource $marketingSource): bool
    {
        return $authUser->can('View:MarketingSource');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MarketingSource');
    }

    public function update(AuthUser $authUser, MarketingSource $marketingSource): bool
    {
        return $authUser->can('Update:MarketingSource');
    }

    public function delete(AuthUser $authUser, MarketingSource $marketingSource): bool
    {
        return $authUser->can('Delete:MarketingSource');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MarketingSource');
    }

    public function restore(AuthUser $authUser, MarketingSource $marketingSource): bool
    {
        return $authUser->can('Restore:MarketingSource');
    }

    public function forceDelete(AuthUser $authUser, MarketingSource $marketingSource): bool
    {
        return $authUser->can('ForceDelete:MarketingSource');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MarketingSource');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MarketingSource');
    }

    public function replicate(AuthUser $authUser, MarketingSource $marketingSource): bool
    {
        return $authUser->can('Replicate:MarketingSource');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MarketingSource');
    }

}