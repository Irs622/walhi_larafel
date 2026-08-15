<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Comment::class);

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
        $this->authorize('update', $comment);

        $comment->status = 'approved';
        $comment->save();

        AuditLogService::log('COMMENT_APPROVE', 'Comment', $comment->id);

        return redirect()->back()->with('success', 'Komentar berhasil disetujui.');
    }

    public function spam(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->status = 'spam';
        $comment->save();

        AuditLogService::log('COMMENT_SPAM', 'Comment', $comment->id);

        return redirect()->back()->with('success', 'Komentar ditandai sebagai spam.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        AuditLogService::log('COMMENT_DELETE', 'Comment', $comment->id);

        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}
