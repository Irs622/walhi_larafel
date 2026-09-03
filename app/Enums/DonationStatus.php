<?php

namespace App\Enums;

enum DonationStatus: string
{
    case Pending = 'pending';
    case Success = 'success';
    case Failed = 'failed';
    case Expired = 'expired';

    /**
     * Human-readable label in Indonesian.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu Pembayaran',
            self::Success => 'Berhasil',
            self::Failed => 'Gagal',
            self::Expired => 'Kadaluarsa',
        };
    }

    /**
     * Whether the donation is considered a completed (successful) transaction.
     */
    public function isCompleted(): bool
    {
        return $this === self::Success;
    }

    /**
     * Determine the status from a Midtrans transaction_status string.
     */
    public static function fromMidtrans(string $transactionStatus): self
    {
        return match ($transactionStatus) {
            'capture', 'settlement' => self::Success,
            'deny', 'cancel' => self::Failed,
            'expire' => self::Expired,
            default => self::Pending,
        };
    }
}
