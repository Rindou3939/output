<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-yellow-600 inline-block">
            新しいクエストを貼る
        </h1>

        <form action="{{ route('posts.store') }}" method="POST" class="space-y-6 bg-yellow-50 p-4 border-2 border-yellow-600 rounded-md shadow">
            @csrf
            <div>
                <label class="block font-semibold text-yellow-900 mb-1" for="title">Title</label>
                <input type="text" id="title" name="post[title]" placeholder="クエストタイトル"
                       value="{{ old('post.title') }}"
                       class="w-full rounded border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">
                @error('post.title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold text-yellow-900 mb-1" for="description">Description</label>
                <textarea id="description" name="post[description]" placeholder="クエストの詳細・ターゲットなど"
                          class="w-full h-24 rounded border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">{{ old('post.description') }}</textarea>
                @error('post.description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold text-yellow-900 mb-1" for="monster_id">Monster</label>
                <select id="monster_id" name="post[monster_id]"
                        class="w-full rounded border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">
                    <option value="">モンスターを選択</option>
                    @foreach ($monsters as $monster)
                        <option value="{{ $monster->id }}" {{ old('post.monster_id') == $monster->id ? 'selected' : '' }}>
                            {{ $monster->name }}
                        </option>
                    @endforeach
                </select>
                @error('post.monster_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold text-yellow-900 mb-1" for="recruitment_target">Recruitment Target</label>
                <input type="number" id="recruitment_target" name="post[recruitment_target]" placeholder="募集人数"
                       value="{{ old('post.recruitment_target') }}"
                       class="w-full rounded border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">
                @error('post.recruitment_target')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                        class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded shadow">
                    保存
                </button>
            </div>
        </form>

        <div class="mt-4">
            <a href="{{ route('posts.index') }}"
               class="inline-block text-blue-600 hover:underline">
                &laquo; 戻る
            </a>
        </div>
    </div>
</x-app-layout>