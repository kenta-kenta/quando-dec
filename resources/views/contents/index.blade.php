<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- 検索フォーム -->
                    <form action="{{ route('contents.index') }}" method="GET" class="mb-6">
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

                    @if(request('query'))
                        <!-- 検索結果 -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-4">
                                「{{ request('query') }}」の検索結果 ({{ $searchResults->total() }}件)
                            </h3>

                            @if ($searchResults->count())
                                @foreach ($searchResults as $content)
                                    <div
                                        class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600">
                                        <p class="text-gray-800 dark:text-gray-300 font-bold">{{ $content->title }}</p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">作成日:
                                            {{ $content->created_at->format('Y-m-d H:i') }}
                                        </p>
                                        <a href="{{ route('contents.show', $content) }}"
                                            class="text-blue-500 hover:text-blue-700">詳細を見る</a>
                                    </div>
                                @endforeach

                                <!-- ページネーション -->
                                <div class="mb-4">
                                    {{ $searchResults->appends(request()->input())->links() }}
                                </div>
                            @else
                                <p class="text-red-500 dark:text-red-400">検索結果が見つかりませんでした。</p>
                            @endif

                            <!-- コンテンツ一覧に戻るボタン -->
                            <div class="text-right mt-4">
                                <a href="{{ route('contents.index') }}"
                                    class="inline-block px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">
                                    一覧に戻る
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- その他のコンテンツ -->
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mt-8 mb-4">
                        {{ request('query') ? 'その他' : '一覧' }}
                    </h3>
                    @if ($otherContents->count())
                        @foreach ($otherContents as $content)
                            <div
                                class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600">
                                <p class="text-gray-800 dark:text-gray-300 font-bold">{{ $content->title }}</p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">作成日:
                                    {{ $content->created_at->format('Y-m-d H:i') }}
                                </p>
                                <a href="{{ route('contents.show', $content) }}"
                                    class="text-blue-500 hover:text-blue-700">詳細を見る</a>
                            </div>
                        @endforeach

                        <!-- ページネーション -->
                        <div class="mt-4">
                            {{ $otherContents->appends(request()->input())->links() }}
                        </div>
                    @else
                        <p>データが見つかりませんでした。</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>