<?php

namespace App\Models;

use App\Enums\DonationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'donor_name',
        'donor_email',
        'donor_phone',
        'amount',
        'status',
        'snap_token',
        'campaign_id',
        'payment_type',
    ];

    protected $casts = [
        'amount' => 'integer',
    ];

    // ──────────────────────────────────────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────────────────────────────────────

    public function campaign()
    {
        return $this->belongsTo(Content::class, 'campaign_id');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Resolve the DonationStatus enum for the current record.
     */
    public function getStatusEnumAttribute(): DonationStatus
    {
        return DonationStatus::from($this->status);
    }

    /**
     * Human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->statusEnum->label();
    }

    /**
     * Whether the donation is completed/successful.
     */
    public function getIsSuccessAttribute(): bool
    {
        return $this->status === DonationStatus::Success->value;
    }
}
