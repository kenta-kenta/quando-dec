<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quando - 会話を構造化するアプリ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white">
    <div class="min-h-screen">
        <!-- ナビゲーション -->
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-blue-600">Quando</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                        @auth
                        <a href="{{ url('/dashboard') }}"
                            class="inline-flex items-center px-4 py-2 text-base font-medium text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            ダッシュボード
                        </a>
                        @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            ログイン
                        </a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center px-6 py-3 text-base font-medium text-blue-600 bg-white border-2 border-blue-600 rounded-md hover:bg-blue-50 transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            新規登録
                        </a>
                        @endif
                        @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- メインコンテンツ -->
        <main class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8">
            <!-- タブナビゲーション -->
            <div class="flex mb-8 border-b border-gray-200">
                <button class="w-1/3 py-3 text-xl text-center font-semibold hover:bg-gray-100 rounded-t-lg"
                    id="tab-purpose" onclick="switchTab('purpose')">
                    目的
                </button>
                <button class="w-1/3 py-3 text-xl text-center font-semibold hover:bg-gray-100 rounded-t-lg"
                    id="tab-features" onclick="switchTab('features')">
                    機能
                </button>
                <button class="w-1/3 py-3 text-xl text-center font-semibold hover:bg-gray-100 rounded-t-lg"
                    id="tab-usage" onclick="switchTab('usage')">
                    使用法
                </button>
            </div>

            <!-- タブコンテンツ -->
            <div class="bg-white shadow rounded-lg p-6">
                <div id="content-purpose" class="tab-content">
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">アプリの目的</h3>
                    <p class="text-lg text-gray-700">
                        Quandoは、あなたの会話や思考を効率的に記録し、構造化するためのツールです。
                        日々の会話やミーティングの内容を、AIを活用して自動的に要約・整理することができます。
                    </p>
                </div>

                <div id="content-features" class="tab-content hidden">
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">主な機能</h3>
                    <ul class="list-disc ml-6 text-lg text-gray-700 space-y-2">
                        <li>音声入力による会話の記録</li>
                        <li>AIによる自動要約・構造化</li>
                        <li>タイトル、要約、重要ポイントの自動生成</li>
                        <li>保存したコンテンツの検索・管理</li>
                    </ul>
                </div>

                <div id="content-usage" class="tab-content hidden">
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">使用方法</h3>
                    <div class="text-lg text-gray-700 space-y-4">
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="font-semibold">Step 1: 会話を記録</h4>
                            <p>音声入力または手動でテキストを入力します。</p>
                        </div>
                        <div class="border-l-4 border-green-500 pl-4">
                            <h4 class="font-semibold">Step 2: AIが構造化</h4>
                            <p>入力された内容をAIが自動的に要約・構造化します。</p>
                        </div>
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h4 class="font-semibold">Step 3: 確認と保存</h4>
                            <p>生成された内容を確認し、必要に応じて編集して保存します。</p>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-center">
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition duration-200">
                            今すぐ始める
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function switchTab(tabName) {
            const allContents = document.querySelectorAll('.tab-content');
            allContents.forEach(content => content.classList.add('hidden'));

            const allTabs = document.querySelectorAll('button');
            allTabs.forEach(tab => tab.classList.remove('bg-gray-100', 'text-blue-600'));

            document.getElementById(`content-${tabName}`).classList.remove('hidden');
            document.getElementById(`tab-${tabName}`).classList.add('bg-gray-100', 'text-blue-600');
        }

        document.addEventListener('DOMContentLoaded', () => {
            switchTab('purpose');
        });
    </script>
</body>

</html>