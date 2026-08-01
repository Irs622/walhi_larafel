<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canManageContent();
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->canManageContent();
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->canDelete();
    }
}
