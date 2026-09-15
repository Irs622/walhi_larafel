<?php

namespace App\Policies;

use App\Enums\ContentCategory;
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
    public function create(User $user, ?string $category = null): bool
    {
        if ($category !== null) {
            $catEnum = ContentCategory::tryFrom($category);
            if (! $catEnum) {
                return false;
            }

            if (Content::isSensitiveCategory($category)) {
                return $user->isAdmin();
            }
        }

        return $user->canManageContent();
    }

    /**
     * Determine whether the user can update the content.
     */
    public function update(User $user, Content $content): bool
    {
        if (! ContentCategory::tryFrom($content->category)) {
            return false;
        }

        if (Content::isSensitiveCategory($content->category)) {
            return $user->isAdmin();
        }

        return $user->canManageContent();
    }

    /**
     * Determine whether the user can delete the content.
     */
    public function delete(User $user, Content $content): bool
    {
        if (! ContentCategory::tryFrom($content->category)) {
            return false;
        }

        return $user->canDelete();
    }
}
