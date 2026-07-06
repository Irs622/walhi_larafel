<?php
 
namespace App\Http\Controllers;
 
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
 
class DonationController extends Controller
{
    public function pay(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_phone' => 'required|string|max:20',
            'amount' => 'required|integer|min:10000',
        ]);

        if (!empty($validated['campaign_id'])) {
            $campaign = \App\Models\Content::find($validated['campaign_id']);
            if (!$campaign || $campaign->category !== 'donasi') {
                return response()->json([
                    'success' => false,
                    'message' => 'Kampanye donasi tidak valid.'
                ], 422);
            }
        }

        $orderId = 'WALHI-DON-' . time() . '-' . Str::upper(Str::random(4));
        $serverKey = config('midtrans.server_key');
        $isProduction = config('midtrans.is_production');
 
        $donation = new Donation();
        $donation->order_id = $orderId;
        $donation->donor_name = $validated['donor_name'];
        $donation->donor_email = $validated['donor_email'];
        $donation->donor_phone = $validated['donor_phone'];
        $donation->amount = $validated['amount'];
        $donation->campaign_id = $validated['campaign_id'] ?? null;
        $donation->status = 'pending';
 
        if ($serverKey) {
            $url = $isProduction 
                ? 'https://app.midtrans.com/snap/v1/transactions' 
                : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
 
            try {
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->withBasicAuth($serverKey, '')
                  ->post($url, [
                      'transaction_details' => [
                          'order_id' => $orderId,
                          'gross_amount' => (int) $validated['amount'],
                      ],
                      'customer_details' => [
                          'first_name' => $validated['donor_name'],
                          'email' => $validated['donor_email'],
                          'phone' => $validated['donor_phone'],
                      ],
                  ]);
 
                if ($response->successful()) {
                    $snapToken = $response->json()['token'];
                    $donation->snap_token = $snapToken;
                    $donation->save();
 
                    return response()->json([
                        'success' => true,
                        'snap_token' => $snapToken,
                        'order_id' => $orderId,
                        'is_mock' => false
                    ]);
                }
            } catch (\Exception $e) {
                // Fail-safe to mock if Midtrans connection fails
            }
        }
 
        // Mock fallback if keys are missing or API fails
        $snapToken = 'MOCK-SNAP-' . Str::random(24);
        $donation->snap_token = $snapToken;
        $donation->save();
 
        return response()->json([
            'success' => true,
            'snap_token' => $snapToken,
            'order_id' => $orderId,
            'is_mock' => true
        ]);
    }
 
    public function webhook(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $serverKey = config('midtrans.server_key');
 
        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey || !$serverKey) {
            return response('Bad Request', 400);
        }
 
        // Validate signature
        $localSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        if ($localSignature !== $signatureKey) {
            return response('Invalid Signature', 403);
        }
 
        $donation = Donation::where('order_id', $orderId)->first();
        if (!$donation) {
            return response('Donation Not Found', 404);
        }
 
        $transactionStatus = $payload['transaction_status'] ?? '';
        $paymentType = $payload['payment_type'] ?? null;
 
        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $donation->status = 'success';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $donation->status = 'failed';
        } elseif ($transactionStatus === 'pending') {
            $donation->status = 'pending';
        }
 
        if ($paymentType) {
            $donation->payment_type = $paymentType;
        }
 
        $donation->save();
 
        return response('OK', 200);
    }
 
    public function mockPaymentStatus(Request $request)
    {
        if (!app()->environment('local', 'testing')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'order_id' => 'required|exists:donations,order_id',
            'status' => 'required|in:success,failed,pending,expired',
        ]);
 
        $donation = Donation::where('order_id', $validated['order_id'])->firstOrFail();
        $donation->status = $validated['status'];
        $donation->payment_type = 'simulation';
        $donation->save();
 
        return response()->json([
            'success' => true,
            'status' => $donation->status,
        ]);
    }
}
