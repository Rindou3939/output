<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b-4 border-yellow-700 inline-block">
            クエスト一覧
        </h1>

        <div class="mb-6">
            <a href="{{ route('posts.create') }}"
               class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded shadow">
                新規クエストを貼る
            </a>
        </div>

        <div class="space-y-6">
            @foreach ($posts as $post)
                <div class="bg-yellow-50 border-2 border-yellow-600 p-4 shadow-md rounded-md relative">
                    <h2 class="text-xl font-semibold text-yellow-900 mb-2">
                        <a href="{{ route('posts.show', $post->id) }}" class="hover:underline">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <p class="text-gray-700 mb-1">{{ $post->description }}</p>
                    <p class="text-sm text-gray-600 mb-1">
                        投稿者:
                        <a href="{{ route('users.show', $post->user->id) }}" class="underline text-blue-600 hover:text-blue-800">
                            {{ $post->user->name }}
                        </a>
                    </p>
                    <p class="text-sm text-gray-600 mb-1">モンスター: {{ $post->monster->name ?? '不明' }}</p>
                    <p class="text-sm text-gray-600 mb-1">募集人数: {{ $post->recruitment_target ?? '-' }}</p>
                    <p class="text-sm text-gray-600 mb-4">現在の募集数: {{ $post->recruitment_count }}</p>

                    <div class="flex items-center space-x-2">
                        <a href="{{ route('posts.show', $post->id) }}"
                           class="text-white bg-green-600 hover:bg-green-700 py-1 px-3 rounded-md shadow">
                            詳細
                        </a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="post" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-white bg-red-600 hover:bg-red-700 py-1 px-3 rounded-md shadow"
                                    onclick="return confirm('本当に削除しますか？')">
                                削除
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class='mt-6'>
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>







