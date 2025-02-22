<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * コメントを保存
     */
    public function store(CommentRequest $request)
    {
        Comment::create([
            'user_id'     => Auth::id(),
            'post_id'     => $request->input('post_id'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('posts.show', $request->input('post_id'))->with('status', 'Comment added!');
    }

    /**
     * コメント編集ページを表示
     */
    public function edit(Comment $comment)
    {
        return view('comments.edit', compact('comment'));
    }

    /**
     * コメントを更新
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update([
            'description' => $request->input('description'),
        ]);

        return redirect()->route('posts.show', $comment->post_id)->with('status', 'Comment updated successfully!');
    }

    /**
     * コメントを削除
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('status', 'Comment deleted!');
    }
}
