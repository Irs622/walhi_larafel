<?php

namespace App\Http\Controllers;

use App\Enums\DonationStatus;
use App\Http\Requests\Donation\InitiateDonationRequest;
use App\Models\Content;
use App\Models\Donation;
use App\Services\Donation\DonationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function __construct(private readonly DonationService $donationService) {}

    /**
     * Initiate a donation checkout. Returns a Snap token (real or mock).
     */
    public function pay(InitiateDonationRequest $request)
    {
        $validated = $request->validated();

        // Validate campaign exists, is a donation campaign, and is published
        if (! empty($validated['campaign_id'])) {
            $campaign = Content::find($validated['campaign_id']);
            if (! $campaign || $campaign->category !== 'donasi' || $campaign->status !== 'published') {
                return response()->json([
                    'success' => false,
                    'message' => 'Kampanye donasi tidak valid atau sudah tidak aktif.',
                ], 422);
            }
        }

        try {
            $result = $this->donationService->initiate($validated);

            return response()->json([
                'success'    => true,
                'snap_token' => $result['snap_token'],
                'order_id'   => $result['order_id'],
                'is_mock'    => $result['is_mock'],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Layanan gateway pembayaran sedang tidak dapat diakses. Silakan coba beberapa saat lagi.',
            ], 503);
        }
    }

    /**
     * Handle Midtrans payment notification webhook.
     * Implementation is idempotent: a successful donation cannot be downgraded.
     */
    public function webhook(Request $request)
    {
        // IP Whitelist Check for Midtrans in Production
        if (config('app.env') === 'production') {
            $clientIp = $request->ip();
            $allowedRanges = [
                // Midtrans production IP ranges (CIDR notation)
                '103.208.23.0/24',
                '103.127.16.0/24',
                '103.127.17.0/24',
                '127.0.0.1/32',
            ];

            $isAllowed = false;
            $ipLong = ip2long($clientIp);
            if ($ipLong !== false) {
                foreach ($allowedRanges as $cidr) {
                    [$subnet, $mask] = explode('/', $cidr);
                    $subnetLong = ip2long($subnet);
                    $maskLong = ~((1 << (32 - (int) $mask)) - 1);
                    if (($ipLong & $maskLong) === ($subnetLong & $maskLong)) {
                        $isAllowed = true;
                        break;
                    }
                }
            }

            if (! $isAllowed) {
                return response('Forbidden IP', 403);
            }
        }

        $payload = $request->all();

        $orderId         = $payload['order_id'] ?? null;
        $statusCode      = $payload['status_code'] ?? null;
        $grossAmount     = $payload['gross_amount'] ?? null;
        $signatureKey    = $payload['signature_key'] ?? null;

        if (! $orderId || ! $statusCode || ! $grossAmount || ! $signatureKey) {
            return response('Bad Request', 400);
        }

        // Validate Midtrans signature using service
        if (! $this->donationService->validateSignature($orderId, $statusCode, $grossAmount, $signatureKey)) {
            return response('Invalid Signature', 403);
        }

        $donation = Donation::where('order_id', $orderId)->first();
        if (! $donation) {
            return response('Donation Not Found', 404);
        }

        // Defense-in-depth: Verify gross amount matches stored donation record
        if ((int) floatval($grossAmount) !== (int) $donation->amount) {
            \Illuminate\Support\Facades\Log::warning('Donation webhook amount mismatch detected', [
                'order_id'        => $orderId,
                'database_amount' => $donation->amount,
                'payload_amount'  => $grossAmount,
            ]);
            return response('Amount Mismatch', 400);
        }

        $transactionStatus = $payload['transaction_status'] ?? '';
        $paymentType       = $payload['payment_type'] ?? null;

        $this->donationService->processWebhook($donation, $transactionStatus, $paymentType);

        return response('OK', 200);
    }

    /**
     * Simulate payment status update — LOCAL / TESTING ONLY.
     * This method is only reachable when the route is registered (see routes/web.php).
     */
    public function mockPaymentStatus(Request $request)
    {
        // Double-check environment as defense-in-depth
        abort_unless(app()->environment('local', 'testing'), 403, 'Mock payment is only available in local or testing environments.');

        $validated = $request->validate([
            'order_id' => ['required', 'exists:donations,order_id'],
            'status'   => ['required', 'in:success,failed,pending,expired'],
        ]);

        $donation = Donation::where('order_id', $validated['order_id'])->firstOrFail();
        $donation->status       = $validated['status'];
        $donation->payment_type = 'simulation';
        $donation->save();

        return response()->json([
            'success' => true,
            'status'  => $donation->status,
        ]);
    }
}
