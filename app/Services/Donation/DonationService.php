<?php

namespace App\Services\Donation;

use App\Enums\DonationStatus;
use App\Models\Donation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DonationService
{
    public function __construct(private readonly MidtransService $midtrans) {}

    /**
     * Initiate a donation: persist a pending Donation record, then attempt
     * to obtain a Midtrans Snap token. Falls back to a mock token only in
     * local or testing environments if Midtrans is unconfigured or unreachable.
     *
     * @return array{donation: Donation, snap_token: string, is_mock: bool}
     *
     * @throws \RuntimeException when payment gateway fails in production
     */
    public function initiate(array $validated): array
    {
        $orderId = $this->generateOrderId();

        $donation = Donation::create([
            'order_id' => $orderId,
            'donor_name' => $validated['donor_name'],
            'donor_email' => $validated['donor_email'],
            'donor_phone' => $validated['donor_phone'],
            'amount' => $validated['amount'],
            'campaign_id' => $validated['campaign_id'] ?? null,
            'status' => DonationStatus::Pending->value,
        ]);

        // Attempt real Midtrans transaction
        if ($this->midtrans->isConfigured()) {
            try {
                $snapToken = $this->midtrans->createTransaction(
                    $orderId,
                    $validated,
                    (int) $validated['amount']
                );

                $donation->update(['snap_token' => $snapToken]);

                return [
                    'donation' => $donation->fresh(),
                    'snap_token' => $snapToken,
                    'order_id' => $orderId,
                    'is_mock' => false,
                ];
            } catch (\RuntimeException $e) {
                Log::error('Midtrans payment transaction initiation failed', [
                    'order_id' => $orderId,
                    'amount' => $validated['amount'],
                    'error' => $e->getMessage(),
                ]);

                if (! app()->environment('local', 'testing')) {
                    throw $e;
                }
            }
        } elseif (! app()->environment('local', 'testing')) {
            Log::error('Midtrans is not configured on production/staging environment', [
                'order_id' => $orderId,
            ]);
            throw new \RuntimeException('Gateway pembayaran belum dikonfigurasi pada server produksi.');
        }

        // Mock fallback strictly for local development and automated testing
        $mockToken = 'MOCK-SNAP-'.Str::upper(Str::random(24));
        $donation->update(['snap_token' => $mockToken]);

        return [
            'donation' => $donation->fresh(),
            'snap_token' => $mockToken,
            'order_id' => $orderId,
            'is_mock' => true,
        ];
    }

    /**
     * Process an incoming Midtrans webhook payload in an atomic and idempotent manner.
     * Enforces strict state transitions after normalizing provider status.
     *
     * @return bool true if status was updated, false if rejected or no change (idempotent)
     */
    public function processWebhook(Donation $donation, string $transactionStatus, ?string $paymentType): bool
    {
        $targetStatus = DonationStatus::fromMidtrans($transactionStatus);

        return (bool) \Illuminate\Support\Facades\DB::transaction(function () use ($donation, $targetStatus, $paymentType, $transactionStatus) {
            $locked = Donation::where('id', $donation->id)->lockForUpdate()->first();
            if (! $locked) {
                return false;
            }

            $currentStatus = DonationStatus::tryFrom($locked->status) ?? DonationStatus::Pending;

            if (! $currentStatus->canTransitionTo($targetStatus)) {
                Log::warning('Midtrans webhook rejected: illegal state transition', [
                    'donation_id' => $locked->id,
                    'order_id' => $locked->order_id,
                    'current_status' => $currentStatus->value,
                    'attempted_status' => $targetStatus->value,
                    'transaction_status' => $transactionStatus,
                ]);

                return false;
            }

            // If already in target status, idempotent acknowledge
            if ($currentStatus === $targetStatus) {
                return false;
            }

            $locked->status = $targetStatus->value;
            if ($paymentType) {
                $locked->payment_type = $paymentType;
            }
            $locked->save();

            $donation->refresh();

            return true;
        });
    }

    /**
     * Validate incoming webhook signature.
     */
    public function validateSignature(string $orderId, string $statusCode, string $grossAmount, string $signature): bool
    {
        return $this->midtrans->validateSignature($orderId, $statusCode, $grossAmount, $signature);
    }

    /**
     * Generate a unique, human-readable order ID.
     */
    private function generateOrderId(): string
    {
        return 'WALHI-DON-'.date('YmdHis').'-'.Str::upper(Str::random(8));
    }
}
