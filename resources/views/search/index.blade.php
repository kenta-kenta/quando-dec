<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('検索') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- 検索フォーム -->
                    <form action="{{ route('search.index') }}" method="GET" class="mb-6">
                        <div class="flex w-[90%] mx-auto gap-4">
                            <input type="text" name="query"
                                class="flex-1 shadow appearance-none border rounded py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="コンテンツを検索..." value="{{ request('query') }}">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 whitespace-nowrap">
                                検索
                            </button>
                        </div>
                    </form>

                    <!-- 検索結果表示 -->
                    @if ($contents->count())
                    <!-- ページネーション -->
                    <div class="mb-4">
                        {{ $contents->appends(request()->input())->links() }}
                    </div>
                    @foreach ($contents as $content)
                    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <p class="text-gray-800 dark:text-gray-300">{{ $content->title }}</p>
                        <a href="{{ route('contents.show', $content) }}"
                            class="text-blue-500 hover:text-blue-700">詳細を見る</a>
                    </div>
                    @endforeach

                    <!-- ページネーション -->
                    <div class="mt-4">
                        {{ $contents->appends(request()->input())->links() }}
                    </div>
                    @else
                    <p>データが見つかりませんでした</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>