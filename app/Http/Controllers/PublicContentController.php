<?php
 
namespace App\Http\Controllers;
 
use App\Models\Content;
use Illuminate\Http\Request;
use Carbon\Carbon;
 
class PublicContentController extends Controller
{
    public function home()
    {
        $news = Content::whereIn('category', ['blog', 'siaran-pers'])
            ->where('status', 'published')
            ->orderBy('is_promoted', 'desc')
            ->orderBy('publish_date', 'desc')
            ->get();
 
        $featuredNews = $news->first();
        $newsCards = $news->skip(1)->take(6);
 
        $reports = Content::where('category', 'laporan-tahunan')
            ->where('status', 'published')
            ->orderBy('publish_date', 'desc')
            ->take(3)
            ->get();

        $sejarah = Content::where('category', 'sejarah')
            ->where('status', 'published')
            ->first();

        $stats = Content::where('category', 'statistik')
            ->where('status', 'published')
            ->orderBy('id', 'asc')
            ->get();

        $issues = Content::where('category', 'isu-kritis')
            ->where('status', 'published')
            ->orderBy('id', 'asc')
            ->get();
 
        return view('welcome', compact('featuredNews', 'newsCards', 'reports', 'sejarah', 'stats', 'issues'));
    }
 
    public function blog(Request $request)
    {
        $categoryFilter = $request->input('kategori') ?: 'Semua';
 
        $query = Content::where('category', 'blog')
            ->where('status', 'published');
 
        if ($categoryFilter && $categoryFilter !== 'Semua') {
            $query->where('tags', 'like', "%{$categoryFilter}%");
        }
 
        $items = $query->orderBy('publish_date', 'desc')->paginate(9)->withQueryString();
 
        return view('blog', compact('items', 'categoryFilter'));
    }
 
    public function show($slug)
    {
        $item = Content::where('slug', $slug)->firstOrFail();
 
        // Increment views count safely
        $item->increment('views');
 
        // Estimate read time
        $wordCount = str_word_count(strip_tags($item->body));
        $readTime = ceil($wordCount / 200);
        $readTime = $readTime > 0 ? $readTime : 1;

        // Fetch related news (same category or overlapping tags, excluding current)
        $relatedNews = Content::where('category', $item->category)
            ->where('status', 'published')
            ->where('id', '!=', $item->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        // If not enough related news, fetch random news from blog/siaran-pers
        if ($relatedNews->count() < 3) {
            $extraNews = Content::whereIn('category', ['blog', 'siaran-pers'])
                ->where('status', 'published')
                ->where('id', '!=', $item->id)
                ->whereNotIn('id', $relatedNews->pluck('id'))
                ->inRandomOrder()
                ->take(3 - $relatedNews->count())
                ->get();
            $relatedNews = $relatedNews->merge($extraNews);
        }

        // Fetch sidebar news (latest 5 published blog/siaran-pers)
        $sidebarNews = Content::whereIn('category', ['blog', 'siaran-pers'])
            ->where('status', 'published')
            ->where('id', '!=', $item->id)
            ->orderBy('publish_date', 'desc')
            ->take(5)
            ->get();
 
        return view('content-detail', compact('item', 'readTime', 'relatedNews', 'sidebarNews'));
    }
}
