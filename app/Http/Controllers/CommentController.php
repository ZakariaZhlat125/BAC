<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'body'       => 'required|string|max:1000',
            'content_id' => 'required|exists:contents,id',
        ]);


        $comment = Comment::create([
            'body'       => $request->body,
            'content_id' => $request->content_id,
            'user_id'    => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment->load('user')
        ]);
    }
}
