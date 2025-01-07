<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('コンテンツ詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg relative">
                <!-- relativeを追加 -->
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('contents.index') }}"
                        class="text-blue-500 hover:text-blue-700 mb-4 inline-block">一覧に戻る</a>

                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-300">{{ $content->title }}</h3>

                    <div class="mt-4 text-gray-600 dark:text-gray-400">
                        <p class="text-sm">作成日: {{ $content->created_at->format('Y-m-d H:i') }}</p>
                        <p class="text-sm">更新日: {{ $content->updated_at->format('Y-m-d H:i') }}</p>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">構造化データ</h4>
                        <div class="mt-2 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <pre
                                class="text-gray-800 dark:text-gray-300 whitespace-pre-wrap">{{ json_encode(json_decode($content->structure), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>

                    < class="mt-6">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">元データ</h4>
                        <div class="mt-2 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <p class="text-gray-800 dark:text-gray-300">{{ $content->text }}</p>
                        </div>
                </div>
                <div class="flex mt-6">
                    <!-- 削除ボタン -->
                    <form action="{{ route('contents.destroy', $content->id) }}" method="POST"
                        onsubmit="return confirm('本当に削除しますか？');" class="absolute top-4 right-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">削除</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>