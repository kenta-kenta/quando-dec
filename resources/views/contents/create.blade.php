<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('テキスト入力フォーム') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">{{ __('テキストを入力してください') }}</h3>

                    <!-- 音声認識コントロール -->
                    <div class="mb-4 flex items-center space-x-4">
                        <button onclick="startRecognition()"
                            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                            音声入力開始
                        </button>
                        <button onclick="stopRecognition()"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            音声入力停止
                        </button>
                        <span id="status" class="text-gray-600"></span>
                    </div>

                    <!-- フォーム開始 -->
                    <form method="POST" action="{{ route('contents.gemini') }}">
                        @csrf
                        <!-- テキスト入力 -->
                        <div>
                            <label for="text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('テキスト') }}
                            </label>
                            <textarea id="text" name="text" rows="10" required
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

                        <!-- 送信ボタン -->
                        <div class="mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                送信
                            </button>
                        </div>
                    </form>
                    <!-- フォーム終了 -->
                </div>
            </div>
        </div>
    </div>

    <script>
        const recognition = new webkitSpeechRecognition();
        recognition.lang = 'ja-JP';
        recognition.continuous = true;
        recognition.interimResults = true;

        function startRecognition() {
            document.getElementById('status').textContent = '音声認識中...';
            recognition.start();
        }

        function stopRecognition() {
            document.getElementById('status').textContent = '';
            recognition.stop();
        }

        recognition.onresult = function(event) {
            const results = event.results;
            let finalTranscript = '';
            let interimTranscript = '';

            for (let i = event.resultIndex; i < results.length; i++) {
                const transcript = results[i][0].transcript;
                if (results[i].isFinal) {
                    finalTranscript += transcript;
                } else {
                    interimTranscript += transcript;
                }
            }

            if (finalTranscript !== '') {
                const textarea = document.getElementById('text');
                textarea.value = textarea.value + finalTranscript + '\n';
            }
        }

        recognition.onerror = function(event) {
            document.getElementById('status').textContent = '音声認識エラー: ' + event.error;
        }
    </script>
</x-app-layout>