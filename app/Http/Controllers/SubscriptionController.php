<?php

namespace App\Http\Controllers;

use App\Http\Requests\Newsletter\SubscribeRequest;
use App\Models\Subscriber;

class SubscriptionController extends Controller
{
    /**
     * Handle newsletter subscription.
     * Honeypot check is delegated to SubscribeRequest.
     */
    public function subscribe(SubscribeRequest $request)
    {
        // Silently ignore spam to avoid revealing detection to bots
        if ($request->isSpam()) {
            return redirect()->back()->with(
                'subscribe_success',
                'Terima kasih! Anda telah berhasil berlangganan newsletter kami.'
            );
        }

        $email = $request->validated('email');

        $subscriber = Subscriber::where('email', $email)->first();

        if ($subscriber) {
            if (! $subscriber->is_active) {
                $subscriber->is_active = true;
                $subscriber->save();
            }

            return redirect()->back()->with(
                'subscribe_success',
                'Terima kasih! Email Anda sudah terdaftar dalam newsletter kami.'
            );
        }

        Subscriber::create([
            'email' => $email,
            'is_active' => true,
        ]);

        return redirect()->back()->with(
            'subscribe_success',
            'Terima kasih! Anda telah berhasil berlangganan newsletter kami.'
        );
    }
}
