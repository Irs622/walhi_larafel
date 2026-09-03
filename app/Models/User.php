<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Role Helpers
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Resolve the UserRole enum for this user.
     */
    public function getRoleEnumAttribute(): UserRole
    {
        return UserRole::tryFrom($this->role ?? '') ?? UserRole::Subscriber;
    }

    /**
     * Check if the user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->roleEnum === UserRole::Admin;
    }

    /**
     * Check if the user can manage content (admin or editor).
     */
    public function canManageContent(): bool
    {
        return $this->roleEnum->canManageContent();
    }

    /**
     * Check if the user can delete records.
     */
    public function canDelete(): bool
    {
        return $this->roleEnum->canDelete();
    }

    /**
     * Explicitly assign a role to this user (safe assignment without mass assignment risk).
     */
    public function assignRole(string|UserRole $role): static
    {
        $this->role = $role instanceof UserRole ? $role->value : $role;

        return $this;
    }
}
