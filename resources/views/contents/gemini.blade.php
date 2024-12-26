<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gemini応答結果') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- 元のテキスト -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">元のテキスト：</h3>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                            {!! nl2br(e($original_text)) !!}
                        </div>
                    </div>

                    <!-- Geminiの応答 -->
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Geminiの応答：</h3>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                            {!! nl2br(e($response_text)) !!}
                        </div>
                    </div>

                    <!-- 戻るボタン -->
                    <div class="mt-6">
                        <a href="{{ route('contents.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300">
                            戻る
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>