<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends controller {
    public function store(Request $request, $postId) {
        $request->validate([
            'body' => 'required|min:3',
        ]);

        $post = Post::findOrFail($postId);
        $post->comments()->create([
            'body' => $request->body,
        ]);

        return back();
    }
}
