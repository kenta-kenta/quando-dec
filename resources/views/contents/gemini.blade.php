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
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Geminiの応答：</h3>

                        @php
                        $json = json_decode($response_text, true);
                        @endphp

                        <div class="space-y-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm">
                            @if(isset($json['title']))
                            <div class="border-b pb-4 dark:border-gray-600">
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">タイトル：</h4>
                                <p class="text-gray-800 dark:text-gray-200">{{ $json['title'] }}</p>
                            </div>
                            @endif

                            @if(isset($json['summary']))
                            <div class="border-b pb-4 dark:border-gray-600">
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">要約：</h4>
                                <p class="text-gray-800 dark:text-gray-200 leading-relaxed">{{ $json['summary'] }}</p>
                            </div>
                            @endif

                            @if(isset($json['point']))
                            <div class="border-b pb-4 dark:border-gray-600">
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">ポイント：</h4>
                                <ul class="list-disc pl-5 space-y-2">
                                    @foreach($json['point'] as $point)
                                    <li class="text-gray-800 dark:text-gray-200">{{ $point }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if(isset($json['next-action']))
                            <div>
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">次のアクション：</h4>
                                <ul class="list-disc pl-5 space-y-2">
                                    @foreach($json['next-action'] as $action)
                                    <li class="text-gray-800 dark:text-gray-200">{{ $action }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- ボタングループ -->
                    <div class="mt-6 flex justify-between items-center">
                        <a href="{{ route('contents.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300">
                            戻る
                        </a>

                        <form method="POST" action="{{ route('contents.store') }}">
                            @csrf
                            <input type="hidden" name="original_text" value="{{ $original_text }}">
                            <input type="hidden" name="response_text" value="{{ $response_text }}">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                保存
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>