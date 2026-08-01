<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;

class ContentPolicy
{
    /**
     * Determine whether the user can view any contents.
     */
    public function viewAny(User $user): bool
    {
        return $user->canManageContent();
    }

    /**
     * Determine whether the user can create contents.
     */
    public function create(User $user): bool
    {
        return $user->canManageContent();
    }

    /**
     * Determine whether the user can update the content.
     */
    public function update(User $user, Content $content): bool
    {
        return $user->canManageContent();
    }

    /**
     * Determine whether the user can delete the content.
     */
    public function delete(User $user, Content $content): bool
    {
        return $user->canDelete();
    }
}
