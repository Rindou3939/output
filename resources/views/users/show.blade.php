<x-app-layout>
    <h1>{{ $user->name }} のプロフィール</h1>

    <p>フォロワー数: {{ $user->followers->count() }}</p>
    <p>フォロー数: {{ $user->following->count() }}</p>
    
    @if (Auth::id() !== $user->id)
        <form action="{{ Auth::user()->isFollowing($user->id) ? route('users.unfollow', $user->id) : route('users.follow', $user->id) }}" method="POST">
            @csrf
            @if (Auth::user()->isFollowing($user->id))
                @method('DELETE')
                <button type="submit">フォロー解除</button>
            @else
                <button type="submit">フォロー</button>
            @endif
        </form>
    @endif

    @if (Auth::id() !== $user->id)
        <form action="{{ Auth::user()->isBlocking($user->id) ? route('users.unblock', $user->id) : route('users.block', $user->id) }}" method="POST">
            @csrf
            @if (Auth::user()->isBlocking($user->id))
                @method('DELETE')
                <button type="submit">ブロック解除</button>
            @else
                <button type="submit">ブロック</button>
            @endif
        </form>
    @endif

    <div class="back">
        [<a href="{{ route('posts.index') }}">Back</a>]
    </div>
</x-app-layout>