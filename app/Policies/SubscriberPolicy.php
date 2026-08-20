<?php

namespace App\Policies;

use App\Models\Subscriber;
use App\Models\User;

class SubscriberPolicy
{
    /**
     * Determine whether the user can view the list of subscribers.
     */
    public function viewAny(User $user): bool
    {
        return $user->canManageContent();
    }

    /**
     * Determine whether the user can export subscribers.
     */
    public function export(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete a subscriber.
     */
    public function delete(User $user, Subscriber $subscriber): bool
    {
        return $user->canDelete();
    }
}
