<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Geminiの応答 -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Geminiの応答：</h3>

                        @php
                            $json = json_decode($content->structure, true);
                        @endphp

                        <div class="space-y-6 bg-gray-50 rounded-lg p-6 shadow-sm">
                            <form method="POST" action="{{ route('contents.update', $content->id) }}">
                                @csrf
                                @method('PUT')

                                <!-- タイトル -->
                                <div class="border-b pb-4">
                                    <h4 class="font-semibold text-gray-700 mb-2">タイトル：</h4>
                                    <input type="text" name="title" value="{{ old('title', $json['title'] ?? '') }}"
                                        class="w-full p-2 bg-gray-100 text-gray-900 rounded-md border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <!-- 要約 -->
                                <div class="border-b pb-4 border-gray-600">
                                    <h4 class="font-semibold text-gray-700 text-gray-300 mb-2">要約：</h4>
                                    <textarea name="summary"
                                        class="w-full p-2 bg-gray-100 text-gray-900 rounded-md border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('summary', $json['summary'] ?? '') }}</textarea>
                                </div>

                                <!-- ポイント -->
                                <div class="border-b pb-4" id="points">
                                    <h4 class="font-semibold text-gray-700 mb-2">ポイント：</h4>
                                    @if (empty($json['point']))
                                        <div class="flex space-x-4 mb-4 point">
                                            <input type="text" name="point[0]" value=""
                                                class="w-full p-2 bg-gray-100 text-gray-900 rounded-md border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                    @else
                                        @foreach ($json['point'] as $index => $point)
                                            <div class="flex space-x-4 mb-4 point">
                                                <input type="text" name="point[{{ $index }}]"
                                                    value="{{ old('point.' . $index, $point) }}"
                                                    class="w-full p-2 bg-gray-100 text-gray-900 rounded-md border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                                <button type="button"
                                                    class="remove-point inline-flex items-center px-2 py-1 bg-red-500 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                    削除
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                    <button type="button"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        id="add-point">
                                        ポイントを追加
                                    </button>
                                </div>

                                <!-- 次のアクション -->
                                <div id="next-actions">
                                    <h4 class="font-semibold text-gray-700 mb-2">次のアクション：</h4>
                                    @if (empty($json['next-action']))
                                        <div class="flex space-x-4 mb-4 next-action">
                                            <input type="text" name="next_action[0]" value=""
                                                class="w-full p-2 bg-gray-100 text-gray-900 rounded-md border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                    @else
                                        @foreach ($json['next-action'] as $index => $action)
                                            <div class="flex space-x-4 mb-4 next-action">
                                                <input type="text" name="next_action[{{ $index }}]"
                                                    value="{{ old('next_action.' . $index, $action) }}"
                                                    class="w-full p-2 bg-gray-100 text-gray-900 rounded-md border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                                <button type="button"
                                                    class="remove-action inline-flex items-center px-2 py-1 bg-red-500 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                    削除
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                    <button type="button"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        id="add-action">
                                        次のアクションを追加
                                    </button>
                                </div>

                                <!-- 保存ボタン -->
                                <div class="flex justify-end mt-6">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        保存
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- 元のテキスト -->
                    <div class="mb-6">
                        <button class="bg-gray-800 text-white px-4 py-2 rounded-md"
                            onclick="toggleOriginalText()">元のテキストを表示</button>
                        <div id="original-text" class="hidden mt-4 bg-gray-100 rounded-lg p-4">
                            {!! nl2br(e($content->text)) !!}
                        </div>
                    </div>

                    <script>
                        function toggleOriginalText() {
                            const originalTextDiv = document.getElementById('original-text');
                            if (originalTextDiv.classList.contains('hidden')) {
                                originalTextDiv.classList.remove('hidden');
                            } else {
                                originalTextDiv.classList.add('hidden');
                            }
                        }
                    </script>
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
                    class="w-full p-2 bg-gray-100 text-gray-900 rounded-md border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
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
        document.addEventListener("DOMContentLoaded", function () {
            // ポイント追加ボタン
            document.getElementById("add-point").addEventListener("click", () =>
                addItem(SELECTORS.point.container.substring(1), SELECTORS.point.item, 'point'));

            // 次のアクション追加ボタン
            document.getElementById("add-action").addEventListener("click", () =>
                addItem(SELECTORS.action.container.substring(1), SELECTORS.action.item, 'next_action'));

            // 削除機能のイベント委譲
            document.body.addEventListener("click", function (e) {
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