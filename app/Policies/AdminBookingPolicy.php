<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AdminBooking;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminBookingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AdminBooking');
    }

    public function view(AuthUser $authUser, AdminBooking $adminBooking): bool
    {
        return $authUser->can('View:AdminBooking');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AdminBooking');
    }

    public function update(AuthUser $authUser, AdminBooking $adminBooking): bool
    {
        return $authUser->can('Update:AdminBooking');
    }

    public function delete(AuthUser $authUser, AdminBooking $adminBooking): bool
    {
        return $authUser->can('Delete:AdminBooking');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:AdminBooking');
    }

    public function restore(AuthUser $authUser, AdminBooking $adminBooking): bool
    {
        return $authUser->can('Restore:AdminBooking');
    }

    public function forceDelete(AuthUser $authUser, AdminBooking $adminBooking): bool
    {
        return $authUser->can('ForceDelete:AdminBooking');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AdminBooking');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AdminBooking');
    }

    public function replicate(AuthUser $authUser, AdminBooking $adminBooking): bool
    {
        return $authUser->can('Replicate:AdminBooking');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AdminBooking');
    }

}