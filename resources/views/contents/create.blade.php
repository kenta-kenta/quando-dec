<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('テキスト入力フォーム') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 text-blue-600">
                        {{ __('テキストを入力してください') }}
                    </h3>

                    <!-- 音声認識コントロール -->
                    <div class="mb-4 flex items-center space-x-4">
                        <button onclick="startRecognition()"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-200">
                            音声入力開始
                        </button>
                        <button onclick="stopRecognition()"
                            class="px-4 py-2 border border-blue-500 text-blue-500 rounded-lg hover:bg-blue-50 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-200">
                            音声入力停止
                        </button>
                        <span id="status" class="text-blue-600"></span>
                    </div>

                    <div id="interim" class="text-gray-500 italic mt-2"></div>
                    <!-- フォーム開始 -->
                    <form method="POST" action="{{ route('contents.gemini') }}">
                        @csrf
                        <!-- テキスト入力 -->
                        <div>
                            <label for="text" class="block text-sm font-medium text-blue-600">
                                {{ __('テキスト') }}
                            </label>
                            <textarea id="text" name="text" rows="10" required
                                class="mt-1 block w-full rounded-md border-blue-200 bg-white shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900"></textarea>
                        </div>

                        <!-- プルダウンメニュー -->
                        <div>
                            <label for="summary_length" class="block text-sm font-medium text-blue-600">
                                {{ __('要約文字数を選択') }}
                            </label>
                            <select id="summary_length" name="summary_length"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="none" selected>{{ __('文字数指定なし') }}</option>
                                <option value="300">{{ __('300字以内') }}</option>
                                <option value="500">{{ __('500字以内') }}</option>
                                <option value="1000">{{ __('1000字以内') }}</option>
                            </select>
                        </div>

                        <!-- 送信ボタン -->
                        <div class="mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
        recognition.maxAlternatives = 1;

        let finalTranscript = '';
        let recognitionTimer;

        function startRecognition() {
            document.getElementById('status').textContent = '音声認識中...';
            recognition.start();
        }

        function stopRecognition() {
            document.getElementById('status').textContent = '';
            recognition.stop();
        }

        recognition.onresult = function(event) {
            clearTimeout(recognitionTimer);
            const results = event.results;
            let interimTranscript = '';

            for (let i = event.resultIndex; i < results.length; i++) {
                const transcript = results[i][0].transcript;
                if (results[i].isFinal) {
                    finalTranscript += transcript + '\n';
                    document.getElementById('text').value += transcript + '\n';
                } else {
                    interimTranscript += transcript;
                }
            }

            document.getElementById('interim').textContent = interimTranscript;

            // 短い区切り時間（500ms）で確定
            recognitionTimer = setTimeout(() => {
                if (interimTranscript) {
                    document.getElementById('text').value += interimTranscript + '\n';
                    interimTranscript = '';
                    document.getElementById('interim').textContent = '';
                }
            }, 500);
        }

        recognition.onerror = function(event) {
            document.getElementById('status').textContent = '音声認識エラー: ' + event.error;
        }
    </script>
</x-app-layout>