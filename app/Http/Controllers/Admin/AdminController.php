<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContentCategory;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Donation;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Article counts across all publishable categories
        $totalArticles = Content::publishable()->count();

        $activeDonations = Content::ofCategory('donasi')->published()->count();
        $activeEvents    = Content::ofCategory('pekan-rakyat')->published()->count();

        $totalDonationsAmount = Donation::where('status', 'success')->sum('amount');

        // Monthly donation trend — last 12 months (real data only)
        [$labels, $monthsData] = $this->buildMonthlyChart();

        $recentTransactions = Donation::orderBy('created_at', 'desc')->take(5)->get();

        $latestPostings = Content::publishable()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $stats = [
            'total_articles'        => $totalArticles,
            'active_campaigns'      => $activeDonations + $activeEvents,
            'active_donations'      => $activeDonations,
            'active_events'         => $activeEvents,
            'total_donations_amount'=> $totalDonationsAmount,
            'chart_labels'          => $labels,
            'chart_data'            => $monthsData,
            'has_donations'         => array_sum($monthsData) > 0,
        ];

        return view('admin.dashboard', compact('stats', 'recentTransactions', 'latestPostings'));
    }

    /**
     * Build monthly donation chart data (real data only — no mock fallback).
     * Returns [$labels, $data] for the last 12 months.
     *
     * @return array{0: array<string>, 1: array<int>}
     */
    private function buildMonthlyChart(): array
    {
        $labels = [];
        $data   = [];

        for ($i = 11; $i >= 0; $i--) {
            $month    = Carbon::now()->startOfMonth()->subMonths($i);
            $labels[] = $month->translatedFormat("M 'y");
            $data[]   = (int) Donation::where('status', 'success')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
        }

        return [$labels, $data];
    }
}
