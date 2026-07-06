<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');

        $query = Comment::with(['content', 'parent'])
            ->orderBy('created_at', 'desc');

        if (in_array($status, ['pending', 'approved', 'spam'])) {
            $query->where('status', $status);
        }

        $comments = $query->paginate(15)->withQueryString();

        return view('admin.comments.index', compact('comments', 'status'));
    }

    public function approve(Comment $comment)
    {
        $comment->status = 'approved';
        $comment->save();

        return redirect()->back()->with('success', 'Komentar berhasil disetujui.');
    }

    public function spam(Comment $comment)
    {
        $comment->status = 'spam';
        $comment->save();

        return redirect()->back()->with('success', 'Komentar ditandai sebagai spam.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}
