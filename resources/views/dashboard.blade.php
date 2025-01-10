<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('使い方') }}
        </h2>
    </x-slot>

    <button onclick=start()>スタート</button>
    <button onclick=stop()>ストップ</button>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- タブナビゲーション -->
                    <div class="flex mb-8">
                        <button
                            class="w-1/3 py-2 text-xl text-center font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 rounded-t-lg"
                            id="tab-purpose" onclick="switchTab('purpose')">
                            目的
                        </button>
                        <button
                            class="w-1/3 py-2 text-xl text-center font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 rounded-t-lg"
                            id="tab-features" onclick="switchTab('features')">
                            機能
                        </button>
                        <button
                            class="w-1/3 py-2 text-xl text-center font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 rounded-t-lg"
                            id="tab-usage" onclick="switchTab('usage')">
                            使用法
                        </button>
                    </div>

                    <!-- タブコンテンツ -->
                    <div id="content-purpose" class="tab-content">
                        <h3 class="text-2xl font-bold mb-4">アプリの目的</h3>
                        <p class="text-lg">
                            このアプリは、ユーザーが入力したテキストを要約・構造化し、保存することができます。ユーザーは、自分や他の人との会話や独り言を記録し、知識の継承や記憶・メモとして活用できます。
                        </p>
                    </div>

                    <div id="content-features" class="tab-content hidden">
                        <h3 class="text-2xl font-bold mb-4">主な機能</h3>
                        <ul class="list-disc ml-6 text-lg">
                            <li>テキストを要約・構造化する機能</li>
                            <li>構造化したコンテンツを保存して一覧表示する機能</li>
                            <li>保存したコンテンツを検索する機能</li>
                        </ul>
                    </div>

                    <div id="content-usage" class="tab-content hidden">
                        <h3 class="text-2xl font-bold mb-4">使用法</h3>
                        <p class="text-lg mb-4">
                            アプリを使用するには、以下のステップを踏んでください：
                        </p>
                        <ul class="list-decimal ml-6 text-lg">
                            <li>
                                <strong>入力・保存： </strong>「入力・保存」タブからテキストを入力し、要約文字数を選択して保存します。
                            </li>
                            <li>
                                <strong>一覧・検索： </strong>「一覧・検索」タブから保存したコンテンツを検索したり、一覧で確認することができます。
                            </li>
                        </ul>
                        <div class="mt-6">
                            <a href="{{ route('contents.create') }}"
                                class="inline-block px-6 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                入力・保存ページへ
                            </a>
                            <a href="{{ route('contents.index') }}"
                                class="inline-block px-6 py-3 text-lg font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 mt-4 ml-4">
                                一覧・検索ページへ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // すべてのタブコンテンツを非表示
            const allContents = document.querySelectorAll('.tab-content');
            allContents.forEach(content => content.classList.add('hidden'));

            // すべてのタブを非アクティブ状態に
            const allTabs = document.querySelectorAll('button');
            allTabs.forEach(tab => tab.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'font-bold'));

            // 指定されたタブを表示
            const activeTab = document.getElementById(`content-${tabName}`);
            activeTab.classList.remove('hidden');

            // 指定されたタブをアクティブに
            const activeButton = document.getElementById(`tab-${tabName}`);
            activeButton.classList.add('bg-gray-200', 'dark:bg-gray-700', 'font-bold');
        }

        // デフォルトで「目的」タブを表示
        document.addEventListener('DOMContentLoaded', () => {
            switchTab('purpose');
        });

        SpeechRecognition = webkitSpeechRecognition || SpeechRecognition;
        const recognition = new SpeechRecognition();
        recognition.lang = 'ja-JP';
        recognition.continuous = true;

        function start() {
            recognition.start();
        }

        function stop() {
            recognition.stop();
        }

        recognition.onresult = (event) => {
            for (let i = event.resultIndex; i < event.results.length; i++) {
                if (event.results[i].isFinal) {
                    alert(event.results[i][0].transcript);
                }
            }
        }
    </script>

</x-app-layout>