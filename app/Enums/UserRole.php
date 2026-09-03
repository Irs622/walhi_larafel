<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Editor = 'editor';
    case Subscriber = 'subscriber';

    /**
     * Human-readable label in Indonesian.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Editor => 'Editor',
            self::Subscriber => 'Pelanggan / Anggota',
        };
    }

    /**
     * Whether this role can perform destructive actions (delete).
     */
    public function canDelete(): bool
    {
        return $this === self::Admin;
    }

    /**
     * Whether this role can manage content (create/edit).
     */
    public function canManageContent(): bool
    {
        return in_array($this, [self::Admin, self::Editor], true);
    }
}
