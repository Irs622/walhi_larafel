<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class AdminSubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function export()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="newsletter_subscribers_' . now()->format('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Email', 'Status', 'Tanggal Daftar']);

            // Chunk records to prevent memory exhaustion
            Subscriber::orderBy('id')->chunk(500, function ($subscribers) use ($file) {
                foreach ($subscribers as $subscriber) {
                    fputcsv($file, [
                        $subscriber->id,
                        $subscriber->email,
                        $subscriber->is_active ? 'Aktif' : 'Tidak Aktif',
                        $subscriber->created_at ? $subscriber->created_at->format('Y-m-d H:i:s') : '',
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus.');
    }
}
