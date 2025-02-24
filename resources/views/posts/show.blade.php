<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-6">
        <div class="bg-yellow-50 border-2 border-yellow-600 p-6 shadow-md rounded-md">
            <h1 class="text-2xl font-bold text-yellow-900 mb-4">{{ $post->title }}</h1>

            <p class="text-gray-700 mb-2">{{ $post->description }}</p>
            <p class="text-sm text-gray-600 mb-1">モンスター: {{ $post->monster->name ?? '不明' }}</p>
            <p class="text-sm text-gray-600 mb-1">参加人数: {{ $post->recruitment_target ?? '-' }}</p>

            @php
                // 現在の参加人数を取得
                $currentCount = $post->users->count();

                // 募集上限に達しているかどうか
                $maxReached = $currentCount >= $post->recruitment_target;

                // ログインユーザーが既に参加しているかどうか
                $isJoined = $post->users->contains(auth()->id());
            @endphp

            {{-- 募集上限に達していない場合、または既に参加している場合のみボタンを表示 --}}
            @if (!$maxReached || $isJoined)
                <div class="flex space-x-2">
                    @if ($isJoined)
                        {{-- 既に参加中の場合は「参加辞退」ボタンを表示 --}}
                        <form action="{{ route('posts.leave', $post->id) }}" method="post">
                            @csrf
                            <button type="submit"
                                    class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded shadow">
                                参加辞退
                            </button>
                        </form>
                    @else
                        {{-- 参加していない場合は、募集上限に達していなければ「参加」ボタンを表示 --}}
                        <form action="{{ route('posts.join', $post->id) }}" method="post">
                            @csrf
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow">
                                参加
                            </button>
                        </form>
                    @endif
                </div>
            @endif

            {{-- 参加人数を表示 --}}
            <p class="text-sm text-gray-600 mt-2">現在の参加人数: {{ $post->users->count() }} 人</p>

            <div class="flex items-center space-x-2 mb-4">
                <a href="{{ route('posts.edit', $post->id) }}"
                   class="text-white bg-green-600 hover:bg-green-700 py-1 px-3 rounded-md shadow">
                    Edit
                </a>
                <form action="{{ route('posts.destroy', $post->id) }}" method="post" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-700 py-1 px-3 rounded-md shadow"
                            onclick="return confirm('本当に削除しますか？')">
                        Delete
                    </button>
                </form>
            </div>

            <div class="mt-2">
                <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">
                    &laquo; 一覧に戻る
                </a>
            </div>
        </div>

        {{-- コメント一覧 --}}
        <div class="mt-8">
            <h2 class="text-xl font-bold text-yellow-900 mb-4">コメント一覧</h2>
            <div class="space-y-4">
                @foreach ($post->comments as $comment)
                    <div class="bg-white border border-gray-300 rounded-md p-4 shadow-sm">
                        <p class="text-gray-800">
                            <strong>{{ $comment->user->name }}</strong>: {{ $comment->description }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $comment->created_at->format('Y-m-d H:i') }}
                        </p>

                        @if (Auth::id() === $comment->user_id)
                            <div class="flex items-center space-x-2 mt-2">
                                <a href="{{ route('comments.edit', $comment->id) }}"
                                   class="text-white bg-green-600 hover:bg-green-700 px-2 py-1 rounded">
                                    編集
                                </a>
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="post" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-white bg-red-600 hover:bg-red-700 px-2 py-1 rounded"
                                            onclick="return confirm('本当に削除しますか？')">
                                        削除
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- コメント投稿フォーム --}}
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-yellow-900 mb-2">コメントを投稿する</h3>
            <form action="{{ route('comments.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}"/>
                <textarea name="description" placeholder="コメントを入力してください" required
                          class="w-full h-20 rounded border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow">
                    投稿
                </button>
            </form>
        </div>
    </div>
</x-app-layout>