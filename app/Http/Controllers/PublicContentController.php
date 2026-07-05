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
            ->orderBy('publish_date', 'desc')
            ->get();
 
        $featuredNews = $news->first();
        $newsCards = $news->skip(1)->take(6);
 
        $reports = Content::where('category', 'laporan-tahunan')
            ->where('status', 'published')
            ->orderBy('publish_date', 'desc')
            ->take(3)
            ->get();
 
        return view('welcome', compact('featuredNews', 'newsCards', 'reports'));
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
 
        // Estimate read time
        $wordCount = str_word_count(strip_tags($item->body));
        $readTime = ceil($wordCount / 200);
        $readTime = $readTime > 0 ? $readTime : 1;
 
        return view('content-detail', compact('item', 'readTime'));
    }
}
