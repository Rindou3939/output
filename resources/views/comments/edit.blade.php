<x-app-layout>
    <h1>コメントを編集</h1>

    @auth
        @if (Auth::id() === $comment->user_id)
            <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="description">
                    <h2>コメント内容</h2>
                    <textarea name="description">{{ old('description', $comment->description) }}</textarea>
                    @error('description')
                        <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>

                <input type="submit" value="更新"/>
            </form>
        @else
            <p style="color:red">このコメントを編集する権限がありません。</p>
        @endif
    @else
        <p style="color:red">ログインしてください。</p>
    @endauth

    <div class="back">
        [<a href="{{ route('posts.show', $comment->post_id) }}">Back</a>]
    </div>
</x-app-layout>