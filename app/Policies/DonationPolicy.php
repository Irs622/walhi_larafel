<?php

namespace App\Policies;

use App\Models\Donation;
use App\Models\User;

class DonationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canManageContent();
    }

    public function delete(User $user, Donation $donation): bool
    {
        return $user->canDelete();
    }
}
