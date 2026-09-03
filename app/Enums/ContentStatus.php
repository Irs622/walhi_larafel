<?php

namespace App\Enums;

enum ContentStatus: string
{
    case Published = 'published';
    case Draft = 'draft';
    case Archived = 'archived';

    /**
     * Human-readable label in Indonesian.
     */
    public function label(): string
    {
        return match ($this) {
            self::Published => 'Dipublikasikan',
            self::Draft => 'Draf',
            self::Archived => 'Diarsipkan',
        };
    }

    /**
     * Badge color class for UI display.
     */
    public function color(): string
    {
        return match ($this) {
            self::Published => 'green',
            self::Draft => 'yellow',
            self::Archived => 'gray',
        };
    }
}
