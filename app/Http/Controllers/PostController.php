<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Monster;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth; 

class PostController extends Controller
{
    public function index(Post $post)
    {
        $posts = Post::with(['user', 'monster'])->orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $monsters = Monster::all(); // モンスター一覧を取得
        return view('posts.create', compact('monsters'));
    }

    public function store(Post $post, PostRequest $request) 
    {
        $data = $request->input('post');

        $userId = Auth::id() ?? 1; // ユーザーID
        $monsterId = $data['monster_id']; // フォームから選択されたモンスターID

        Post::create([
            'user_id'             => $userId,
            'monster_id'          => $monsterId,
            'title'               => $data['title'],
            'description'         => $data['description'],
            'recruitment_target'  => $data['recruitment_target'] ?? null,
        ]);

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        $monsters = Monster::all();
        return view('posts.edit', compact('post', 'monsters'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $data = $request->input('post');

        $post->update([
            'title'              => $data['title'],
            'description'        => $data['description'],
            'monster_id'         => $data['monster_id'],
            'recruitment_target' => $data['recruitment_target'] ?? null,
        ]);
    
        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/');
    }

    public function join($id)
    {
        $post = Post::findOrFail($id);

        // 募集人数を超えていない場合のみ増加
        if ($post->recruitment_target > $post->recruitment_count) {
            $post->increment('recruitment_count');
        }

        return redirect()->back()->with('success', '参加しました！');
    }
}