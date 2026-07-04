<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Calculate dynamic stats
        $totalArticles = Content::whereIn('category', [
            'blog', 'regulasi', 'siaran-pers', 'infografis', 
            'kertas-posisi', 'newsletter', 'buletin-bumi', 
            'jurnal', 'laporan-tahunan'
        ])->count();

        $activeDonations = Content::where('category', 'donasi')
            ->where('status', 'published')
            ->count();
            
        $activeEvents = Content::where('category', 'pekan-rakyat')
            ->where('status', 'published')
            ->count();

        $stats = [
            'total_articles' => $totalArticles,
            'active_campaigns' => $activeDonations + $activeEvents,
            'active_donations' => $activeDonations,
            'active_events' => $activeEvents,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
