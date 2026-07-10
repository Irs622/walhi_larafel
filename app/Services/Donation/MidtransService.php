<?php

namespace App\Services\Donation;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    private string $serverKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key', '');
        $isProduction    = config('midtrans.is_production', false);

        $this->baseUrl = $isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    /**
     * Whether Midtrans is properly configured with a server key.
     */
    public function isConfigured(): bool
    {
        return ! empty($this->serverKey);
    }

    /**
     * Create a Snap transaction and return the snap_token.
     *
     * @throws \RuntimeException on API failure
     */
    public function createTransaction(string $orderId, array $customerDetails, int $amount): string
    {
        $response = Http::withHeaders([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ])
        ->withBasicAuth($this->serverKey, '')
        ->post($this->baseUrl, [
            'transaction_details' => [
                'order_id'    => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $customerDetails['donor_name'],
                'email'      => $customerDetails['donor_email'],
                'phone'      => $customerDetails['donor_phone'],
            ],
        ]);

        if (! $response->successful()) {
            Log::warning('Midtrans API error', [
                'status'   => $response->status(),
                'body'     => $response->body(),
                'order_id' => $orderId,
            ]);
            throw new \RuntimeException('Midtrans API returned non-2xx response.');
        }

        $token = $response->json('token');

        if (! $token) {
            throw new \RuntimeException('Midtrans API did not return a snap token.');
        }

        return $token;
    }

    /**
     * Validate a Midtrans webhook signature.
     */
    public function validateSignature(
        string $orderId,
        string $statusCode,
        string $grossAmount,
        string $incomingSignature
    ): bool {
        $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);

        return hash_equals($expected, $incomingSignature);
    }
}
