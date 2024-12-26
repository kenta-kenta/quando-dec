<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('コンテンツ一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($contents as $content)
                        <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <p class="text-gray-800 dark:text-gray-300">{{ $content->title }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">作成日:
                                {{ $content->created_at->format('Y-m-d H:i') }}
                            </p>
                            <a href="{{ route('contents.show', $content) }}"
                                class="text-blue-500 hover:text-blue-700">詳細を見る</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>