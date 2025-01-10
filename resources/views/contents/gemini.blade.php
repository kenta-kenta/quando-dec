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
                            {!! nl2br(e($content->text)) !!}
                        </div>
                    </div>

                    <!-- Geminiの応答 -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Geminiの応答：</h3>

                        @php
                        $json = json_decode($content->structure, true);
                        @endphp

                        <div class="space-y-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm">
                            <form method="POST" action="{{ route('contents.update', $content->id) }}">
                                @csrf
                                @method('PUT')

                                <!-- タイトル -->
                                <div class="border-b pb-4 dark:border-gray-600">
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">タイトル：</h4>
                                    <input type="text" name="title" value="{{ old('title', $json['title'] ?? '') }}"
                                        class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <!-- 要約 -->
                                <div class="border-b pb-4 dark:border-gray-600">
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">要約：</h4>
                                    <textarea name="summary"
                                        class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">{{ old('summary', $json['summary'] ?? '') }}</textarea>
                                </div>

                                <!-- ポイント -->
                                <div class="border-b pb-4 dark:border-gray-600" id="points">
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">ポイント：</h4>
                                    @if (empty($json['point']))
                                    <div class="flex space-x-4 mb-4 point">
                                        <input type="text" name="point[0]" value=""
                                            class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    @else
                                    @foreach ($json['point'] as $index => $point)
                                    <div class="flex space-x-4 mb-4 point">
                                        <input type="text" name="point[{{ $index }}]"
                                            value="{{ old('point.' . $index, $point) }}"
                                            class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                                        <button type="button"
                                            class="remove-point text-red-500 hover:text-red-700">削除</button>
                                    </div>
                                    @endforeach
                                    @endif
                                    <button type="button"
                                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 font-semibold rounded-md hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                        id="add-point">
                                        ポイントを追加
                                    </button>
                                </div>

                                <!-- 次のアクション -->
                                <div id="next-actions">
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">次のアクション：</h4>
                                    @if (empty($json['next-action']))
                                    <div class="flex space-x-4 mb-4 next-action">
                                        <input type="text" name="next_action[0]" value=""
                                            class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    @else
                                    @foreach ($json['next-action'] as $index => $action)
                                    <div class="flex space-x-4 mb-4 next-action">
                                        <input type="text" name="next_action[{{ $index }}]"
                                            value="{{ old('next_action.' . $index, $action) }}"
                                            class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                                        <button type="button"
                                            class="remove-action text-red-500 hover:text-red-700">削除</button>
                                    </div>
                                    @endforeach
                                    @endif
                                    <button type="button"
                                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 font-semibold rounded-md hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                        id="add-action">
                                        次のアクションを追加
                                    </button>
                                </div>

                                <!-- 保存ボタン -->
                                <div class="flex justify-end mt-6">
                                    <button type="submit"
                                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                        保存
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-between items-center">
                        <!-- 削除用フォーム (非表示にする) -->
                        <form id="delete-form" method="POST" action="{{ route('contents.destroy', $content->id) }}"
                            style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>

                        <!-- 戻るボタン (削除とリダイレクトを処理) -->
                        <button type="button" onclick="deleteContentAndRedirect()"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300">
                            戻る
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // 定数定義
        const SELECTORS = {
            point: {
                container: '#points',
                item: '.point',
                remove: '.remove-point'
            },
            action: {
                container: '#next-actions',
                item: '.next-action',
                remove: '.remove-action'
            }
        };

        // 共通の入力項目生成関数
        function createInputItem(type, index, className) {
            return `
            <div class="flex space-x-4 mb-4 ${className}">
                <input type="text" 
                    name="${type}[${index}]" 
                    value="" 
                    class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                <button type="button" 
                    class="remove-${type} text-red-500 hover:text-red-700 transition-colors duration-200">
                    削除
                </button>
            </div>
        `;
        }

        // 項目追加の共通処理
        function addItem(containerId, itemClass, type) {
            const container = document.getElementById(containerId);
            const itemCount = container.querySelectorAll(itemClass).length;
            const newItemHTML = createInputItem(type, itemCount, itemClass.substring(1));

            if (itemCount === 0) {
                container.insertAdjacentHTML('beforeend', newItemHTML);
            } else {
                container.querySelector(`${itemClass}:last-of-type`).insertAdjacentHTML('afterend', newItemHTML);
            }
        }

        // 初期化処理
        document.addEventListener("DOMContentLoaded", function() {
            // ポイント追加ボタン
            document.getElementById("add-point").addEventListener("click", () =>
                addItem(SELECTORS.point.container.substring(1), SELECTORS.point.item, 'point'));

            // 次のアクション追加ボタン
            document.getElementById("add-action").addEventListener("click", () =>
                addItem(SELECTORS.action.container.substring(1), SELECTORS.action.item, 'next_action'));

            // 削除機能のイベント委譲
            document.body.addEventListener("click", function(e) {
                if (e.target.classList.contains("remove-point")) {
                    e.target.closest(SELECTORS.point.item).remove();
                } else if (e.target.classList.contains("remove-action")) {
                    e.target.closest(SELECTORS.action.item).remove();
                }
            });
        });

        // 削除とリダイレクトの非同期処理
        async function deleteContentAndRedirect() {
            try {
                const form = document.getElementById('delete-form');
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('削除処理に失敗しました');
            } catch (error) {
                console.error('エラー:', error);
                alert('削除処理中にエラーが発生しました');
            }
        }
    </script>
</x-app-layout>