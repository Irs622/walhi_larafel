<?php

namespace App\Http\Controllers;

use App\Enums\ContentCategory;
use App\Models\Content;
use Illuminate\Http\Request;

class PublicContentController extends Controller
{
    public function home()
    {
        $news = Content::ofCategory(ContentCategory::newsValues())
            ->published()
            ->orderBy('is_promoted', 'desc')
            ->orderBy('publish_date', 'desc')
            ->get();

        $featuredNews = $news->first();
        $newsCards    = $news->skip(1)->take(6);

        $reports = Content::ofCategory(ContentCategory::LaporanTahunan)
            ->published()
            ->orderBy('publish_date', 'desc')
            ->take(3)
            ->get();

        $sejarah = Content::ofCategory(ContentCategory::Sejarah)
            ->published()
            ->first();

        $stats = Content::ofCategory(ContentCategory::Statistik)
            ->published()
            ->orderBy('id', 'asc')
            ->get();

        $issues = Content::ofCategory(ContentCategory::IsuKritis)
            ->published()
            ->orderBy('id', 'asc')
            ->get();

        return view('welcome', compact('featuredNews', 'newsCards', 'reports', 'sejarah', 'stats', 'issues'));
    }

    public function blog(Request $request)
    {
        $categoryFilter = $request->input('kategori') ?: 'Semua';

        $query = Content::ofCategory(ContentCategory::Blog)->published();

        if ($categoryFilter && $categoryFilter !== 'Semua') {
            $escapedFilter = str_replace(['%', '_'], ['\%', '\_'], $categoryFilter);
            $query->where('tags', 'like', "%{$escapedFilter}%");
        }

        $items = $query->orderBy('publish_date', 'desc')->paginate(9)->withQueryString();

        return view('blog', compact('items', 'categoryFilter'));
    }

    public function show(string $slug)
    {
        // Eager-load approved top-level comments with their approved replies
        // to eliminate N+1 queries on the detail page.
        $item = Content::where('slug', $slug)
            ->withCount(['comments as approved_comments_count' => function ($q) {
                $q->where('status', 'approved');
            }])
            ->firstOrFail();

        // Increment views count with session deduplication
        $sessionKey = 'viewed_content_' . $item->id;
        if (!session()->has($sessionKey)) {
            $item->increment('views');
            session()->put($sessionKey, true);
        }

        // Read time is now an accessor on the model
        $readTime = $item->read_time;

        // Fetch approved top-level comments with pre-loaded approved replies
        $approvedComments = $item->comments()
            ->where('status', 'approved')
            ->whereNull('parent_id')
            ->with(['replies' => fn ($q) => $q->where('status', 'approved')->orderBy('created_at', 'asc')])
            ->orderBy('created_at', 'desc')
            ->get();

        // Related content (same category, exclude current)
        $relatedNews = Content::ofCategory($item->category)
            ->published()
            ->where('id', '!=', $item->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Top-up with blog/siaran-pers if not enough related content
        if ($relatedNews->count() < 3) {
            $extraNews = Content::ofCategory(ContentCategory::newsValues())
                ->published()
                ->where('id', '!=', $item->id)
                ->whereNotIn('id', $relatedNews->pluck('id'))
                ->inRandomOrder()
                ->take(3 - $relatedNews->count())
                ->get();
            $relatedNews = $relatedNews->merge($extraNews);
        }

        // Sidebar: latest 5 published news
        $sidebarNews = Content::ofCategory(ContentCategory::newsValues())
            ->published()
            ->where('id', '!=', $item->id)
            ->orderBy('publish_date', 'desc')
            ->take(5)
            ->get();

        return view('content-detail', compact('item', 'readTime', 'relatedNews', 'sidebarNews', 'approvedComments'));
    }
}
