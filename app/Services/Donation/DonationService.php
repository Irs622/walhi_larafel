<?php

namespace App\Services\Donation;

use App\Enums\DonationStatus;
use App\Models\Donation;
use Illuminate\Support\Str;

class DonationService
{
    public function __construct(private readonly MidtransService $midtrans) {}

    /**
     * Initiate a donation: persist a pending Donation record, then attempt
     * to obtain a Midtrans Snap token. Falls back to a mock token if Midtrans
     * is unconfigured or unreachable (e.g., local development).
     *
     * @return array{donation: Donation, snap_token: string, is_mock: bool}
     */
    public function initiate(array $validated): array
    {
        $orderId = $this->generateOrderId();

        $donation = Donation::create([
            'order_id'    => $orderId,
            'donor_name'  => $validated['donor_name'],
            'donor_email' => $validated['donor_email'],
            'donor_phone' => $validated['donor_phone'],
            'amount'      => $validated['amount'],
            'campaign_id' => $validated['campaign_id'] ?? null,
            'status'      => DonationStatus::Pending->value,
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
                    'donation'   => $donation->fresh(),
                    'snap_token' => $snapToken,
                    'order_id'   => $orderId,
                    'is_mock'    => false,
                ];
            } catch (\RuntimeException $e) {
                // Fall through to mock
            }
        }

        // Mock fallback for local dev or when Midtrans is unreachable
        $mockToken = 'MOCK-SNAP-' . Str::upper(Str::random(24));
        $donation->update(['snap_token' => $mockToken]);

        return [
            'donation'   => $donation->fresh(),
            'snap_token' => $mockToken,
            'order_id'   => $orderId,
            'is_mock'    => true,
        ];
    }

    /**
     * Process an incoming Midtrans webhook payload in an idempotent manner.
     * Once a donation reaches "success", it cannot be downgraded.
     *
     * @return bool  true if status was updated, false if already terminal/no change
     */
    public function processWebhook(Donation $donation, string $transactionStatus, ?string $paymentType): bool
    {
        // Guard: never downgrade a successfully completed donation
        if ($donation->status === DonationStatus::Success->value) {
            return false;
        }

        $newStatus = DonationStatus::fromMidtrans($transactionStatus);

        $changed = $donation->status !== $newStatus->value;

        $donation->status = $newStatus->value;

        if ($paymentType) {
            $donation->payment_type = $paymentType;
        }

        $donation->save();

        return $changed;
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
        return 'WALHI-DON-' . date('YmdHis') . '-' . Str::upper(Str::random(8));
    }
}
