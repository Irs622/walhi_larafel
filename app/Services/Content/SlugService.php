<?php

namespace App\Services\Content;

use App\Models\Content;
use Illuminate\Support\Str;

class SlugService
{
    /**
     * Generate a unique slug, optionally excluding the record being updated.
     *
     * Example:
     *   makeUnique('my-article')         → 'my-article' (if available)
     *   makeUnique('my-article')         → 'my-article-1' (if 'my-article' exists)
     *   makeUnique('my-article', 5)      → ignores content with id=5 (for updates)
     */
    public function makeUnique(string $slug, ?int $excludeId = null): string
    {
        $slug  = Str::slug($slug);
        $query = Content::where('slug', 'like', $slug . '%');

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        $existingSlugs = $query->pluck('slug')->toArray();

        if (! in_array($slug, $existingSlugs)) {
            return $slug;
        }

        $count = 1;
        while (in_array("{$slug}-{$count}", $existingSlugs)) {
            $count++;
        }

        return "{$slug}-{$count}";
    }
}
