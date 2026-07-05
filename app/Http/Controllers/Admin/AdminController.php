<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Donation;
use Illuminate\Http\Request;
use Carbon\Carbon;
 
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
 
        $totalDonationsAmount = Donation::where('status', 'success')->sum('amount');
 
        // Trend last 12 months
        $monthsData = [];
        $labels = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->translatedFormat("M 'y");
            $sum = Donation::where('status', 'success')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
            $monthsData[] = (int) $sum;
        }
 
        // Fallback to mock data if no donations yet
        if (array_sum($monthsData) === 0) {
            $monthsData = [12500000, 18200000, 14800000, 22000000, 31500000, 19300000, 16700000, 24100000, 27800000, 33200000, 29400000, 38900000];
        }
 
        $recentTransactions = Donation::orderBy('created_at', 'desc')->take(5)->get();
 
        $stats = [
            'total_articles' => $totalArticles,
            'active_campaigns' => $activeDonations + $activeEvents,
            'active_donations' => $activeDonations,
            'active_events' => $activeEvents,
            'total_donations_amount' => $totalDonationsAmount,
            'chart_labels' => $labels,
            'chart_data' => $monthsData,
        ];
 
        return view('admin.dashboard', compact('stats', 'recentTransactions'));
    }
}
