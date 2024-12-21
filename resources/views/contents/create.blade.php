<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('テキスト入力フォーム') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">{{ __('テキストを入力してください') }}</h3>

                    <!-- フォーム開始 -->
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <!-- テキスト入力 -->
                        <div>
                            <label for="text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('テキスト') }}
                            </label>
                            <textarea id="text" name="text" rows="5" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100"></textarea>
                        </div>

                        <!-- プルダウンメニュー -->
                        <div>
                            <label for="summary_length"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('要約文字数を選択') }}
                            </label>
                            <select id="summary_length" name="summary_length"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100">
                                <option value="none" selected>{{ __('文字数指定なし') }}</option>
                                <option value="300">{{ __('300字以内') }}</option>
                                <option value="500">{{ __('500字以内') }}</option>
                                <option value="1000">{{ __('1000字以内') }}</option>
                            </select>
                        </div>

                        <!-- 保存ボタン -->
                        <div class="text-right">
                            <button type="submit"
                                class="px-6 py-2 bg-indigo-600 text-white font-bold text-sm rounded-md shadow-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                                {{ __('保存') }}
                            </button>
                        </div>
                    </form>
                    <!-- フォーム終了 -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>