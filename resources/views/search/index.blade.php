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
                    <form action="{{ route('search.results') }}" method="GET">
                        <input type="text" name="query" placeholder="検索キーワード" class="p-2 border rounded" required>
                        <button type="submit" class="ml-2 p-2 bg-blue-500 text-white rounded">検索</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>