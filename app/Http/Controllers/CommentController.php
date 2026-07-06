<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Content $content)
    {
        // Honeypot check to block bots
        if ($request->filled('extra_phone')) {
            // Silently ignore to avoid alerting the spam bot
            return redirect()->back()->with('comment_success', 'Komentar Anda berhasil dikirim dan sedang menunggu moderasi admin.');
        }

        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'body' => 'required|string|max:5000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = new Comment($validated);
        $comment->content_id = $content->id;
        $comment->status = 'pending';
        $comment->save();

        return redirect()->back()->with('comment_success', 'Komentar Anda berhasil dikirim dan sedang menunggu moderasi admin.');
    }
}
