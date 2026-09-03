<?php

namespace App\Models;

use App\Enums\ContentCategory;
use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Content extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'tags',
        'status',
        'image_url',
        'publish_date',
        'category',
        'is_promoted',
        'author',
        'views',
    ];

    protected $casts = [
        'publish_date' => 'date:Y-m-d',
        'is_promoted' => 'boolean',
        'views' => 'integer',
    ];

    // ──────────────────────────────────────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────────────────────────────────────

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'campaign_id');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Eloquent Scopes
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Filter only published content.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', ContentStatus::Published->value);
    }

    /**
     * Filter by a single category or an array of categories.
     *
     * @param  string|ContentCategory|string[]|ContentCategory[]  $category
     */
    public function scopeOfCategory(Builder $query, string|ContentCategory|array $categories): Builder
    {
        // Normalise to array of string values
        $values = collect((array) $categories)->map(function ($cat) {
            return $cat instanceof ContentCategory ? $cat->value : $cat;
        })->all();

        return count($values) === 1
            ? $query->where('category', $values[0])
            : $query->whereIn('category', $values);
    }

    /**
     * Filter only promoted content.
     */
    public function scopePromoted(Builder $query): Builder
    {
        return $query->where('is_promoted', true);
    }

    /**
     * Filter by publishable editorial categories.
     */
    public function scopePublishable(Builder $query): Builder
    {
        return $query->whereIn('category', ContentCategory::publishableCategoryValues());
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Get the properly formatted image/file URL.
     */
    public function getImageUrlAttribute(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        $value = trim($value);

        // Explicitly block dangerous URI schemes
        if (preg_match('/^(javascript|vbscript|data):/i', $value)) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        if (str_starts_with($value, '/storage/')) {
            return $value;
        }

        if (str_starts_with($value, 'storage/')) {
            return '/'.$value;
        }

        if (str_starts_with($value, 'uploads/')) {
            return '/storage/'.$value;
        }

        if (str_starts_with($value, '/assets/')) {
            return $value;
        }

        if (str_starts_with($value, 'assets/')) {
            return '/'.$value;
        }

        if (str_starts_with($value, '/')) {
            return $value;
        }

        // Only allow clean alphanumeric filename paths for fallback storage prefix
        if (preg_match('/^[a-zA-Z0-9_\-\.\/]+$/', $value)) {
            return '/storage/'.$value;
        }

        return null;
    }

    /**
     * Return a plain-text excerpt (max 155 chars) stripped of HTML.
     */
    public function getExcerptAttribute($value = null, int $length = 155): string
    {
        return Str::limit(strip_tags($this->body ?? ''), $length);
    }

    /**
     * Estimated reading time in minutes (200 wpm average).
     */
    public function getReadTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->body ?? ''));

        return max(1, (int) ceil($wordCount / 200));
    }

    /**
     * Sanitized HTML body to prevent XSS while safely supporting HTML5 structure and clean plain-text fallback.
     */
    public function getSanitizedBodyAttribute(): string
    {
        $raw = trim($this->body ?? '');
        if ($raw === '') {
            return '';
        }

        // If body has no HTML tags at all, format plain text with paragraphs and line breaks
        if (strip_tags($raw) === $raw) {
            $paragraphs = preg_split('/(\r\n|\n|\r){2,}/', $raw);
            $formatted = '';
            foreach ($paragraphs as $p) {
                $p = trim($p);
                if ($p !== '') {
                    $formatted .= '<p>'.nl2br(htmlspecialchars($p, ENT_QUOTES, 'UTF-8')).'</p>';
                }
            }
            $raw = $formatted ?: '<p>'.nl2br(htmlspecialchars($raw, ENT_QUOTES, 'UTF-8')).'</p>';
        }

        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.DefinitionID', 'walhi-html5-content');
        $config->set('HTML.DefinitionRev', 3);
        $config->set('Cache.DefinitionImpl', null);
        $config->set('HTML.TargetBlank', true);
        $config->set('URI.AllowedSchemes', [
            'http' => true,
            'https' => true,
            'mailto' => true,
            'tel' => true,
        ]);
        $config->set('HTML.Allowed', 'p,br,strong,b,em,i,u,ul,ol,li,h2,h3,h4,h5,blockquote,a[href|title|target],img[src|alt|width|height|style|class],table,thead,tbody,tr,th,td,figure,figcaption,hr,span,div');

        if ($def = $config->maybeGetRawHTMLDefinition()) {
            $def->addElement('figure', 'Block', 'Flow', 'Common');
            $def->addElement('figcaption', 'Inline', 'Flow', 'Common');
        }

        $purifier = new \HTMLPurifier($config);

        return $purifier->purify($raw);
    }
}
