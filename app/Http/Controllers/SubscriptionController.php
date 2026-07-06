<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        // Honeypot check to block automated bots
        if ($request->filled('extra_name')) {
            // Silently ignore spam
            return redirect()->back()->with('subscribe_success', 'Terima kasih! Anda telah berhasil berlangganan newsletter kami.');
        }

        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $subscriber = Subscriber::where('email', $validated['email'])->first();

        if ($subscriber) {
            if (!$subscriber->is_active) {
                $subscriber->is_active = true;
                $subscriber->save();
            }
            return redirect()->back()->with('subscribe_success', 'Terima kasih! Email Anda sudah terdaftar dalam newsletter kami.');
        }

        Subscriber::create([
            'email' => $validated['email'],
            'is_active' => true,
        ]);

        return redirect()->back()->with('subscribe_success', 'Terima kasih! Anda telah berhasil berlangganan newsletter kami.');
    }
}
