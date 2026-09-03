<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function index()
    {
        $stats = Cache::remember('admin_dashboard_stats', 300, function () {
            $totalArticles = Content::publishable()->count();

            $activeDonations = Content::ofCategory('donasi')->published()->count();
            $activeEvents = Content::ofCategory('pekan-rakyat')->published()->count();

            $totalDonationsAmount = Donation::where('status', 'success')->sum('amount');

            [$labels, $monthsData] = $this->buildMonthlyChart();

            return [
                'total_articles' => $totalArticles,
                'active_campaigns' => $activeDonations + $activeEvents,
                'active_donations' => $activeDonations,
                'active_events' => $activeEvents,
                'total_donations_amount' => $totalDonationsAmount,
                'chart_labels' => $labels,
                'chart_data' => $monthsData,
                'has_donations' => array_sum($monthsData) > 0,
            ];
        });

        $recentTransactions = Donation::orderBy('created_at', 'desc')->take(5)->get();

        $latestPostings = Content::publishable()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

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
        $data = [];

        $startDate = Carbon::now()->startOfMonth()->subMonths(11);

        $driver = \DB::getDriverName();
        $dateExpr = $driver === 'sqlite'
            ? "strftime('%Y-%m', created_at) as period_key"
            : "DATE_FORMAT(created_at, '%Y-%m') as period_key";

        $monthlyTotals = Donation::where('status', 'success')
            ->where('created_at', '>=', $startDate)
            ->selectRaw("{$dateExpr}, SUM(amount) as total")
            ->groupBy('period_key')
            ->pluck('total', 'period_key');

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->startOfMonth()->subMonths($i);
            $key = $month->format('Y-m');
            $labels[] = $month->translatedFormat("M 'y");
            $data[] = (int) ($monthlyTotals[$key] ?? 0);
        }

        return [$labels, $data];
    }
}
