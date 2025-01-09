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
                            <div class="border-b pb-4 dark:border-gray-600">
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">タイトル：</h4>
                                <input type="text" name="title" value="{{ old('title', $json['title'] ?? '') }}"
                                    class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="border-b pb-4 dark:border-gray-600">
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">要約：</h4>
                                <textarea name="summary"
                                    class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">{{ old('summary', $json['summary'] ?? '') }}</textarea>
                            </div>

                            <!-- ポイント：個別に入力フォームを追加 -->
                            <div class="border-b pb-4 dark:border-gray-600" id="points">
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">ポイント：</h4>
                                @foreach($json['point'] ?? [] as $index => $point)
                                    <div class="flex space-x-4 mb-4 point">
                                        <input type="text" name="point[{{ $index }}]"
                                            value="{{ old('point.' . $index, $point) }}"
                                            class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                                        <button type="button" class="remove-point text-red-500 hover:text-red-700">
                                            削除
                                        </button>
                                    </div>
                                @endforeach
                                <button type="button"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 font-semibold rounded-md hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                    id="add-point">
                                    ポイントを追加
                                </button>
                            </div>

                            <!-- 次のアクション：個別に入力フォームを追加 -->
                            <div id="next-actions">
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">次のアクション：</h4>
                                @foreach($json['next-action'] ?? [] as $index => $action)
                                    <div class="flex space-x-4 mb-4 next-action">
                                        <input type="text" name="next_action[{{ $index }}]"
                                            value="{{ old('next_action.' . $index, $action) }}"
                                            class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                                        <button type="button" class="remove-action text-red-500 hover:text-red-700">
                                            削除
                                        </button>
                                    </div>
                                @endforeach
                                <button type="button"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 font-semibold rounded-md hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                    id="add-action">
                                    次のアクションを追加
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- ボタングループ -->
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

                        <form method="POST" action="{{ route('contents.update', $content->id) }}">
                            @csrf
                            @method('PUT')

                            <input type="text" name="title" value="{{ old('title', $json['title'] ?? '') }}">
                            <textarea name="summary">{{ old('summary', $json['summary'] ?? '') }}</textarea>
                            <input type="text" name="point[{{ $index }}]" value="{{ old('point.' . $index, $point) }}">
                            <input type="text" name="next_action[{{ $index }}]"
                                value="{{ old('next_action.' . $index, $action) }}">


                            <!-- 更新ボタン -->
                            <button type="submit">更新</button>
                        </form>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif



                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // ポイント追加ボタン
            document.getElementById("add-point").addEventListener("click", function () {
                let pointContainer = document.getElementById("points");
                let pointCount = pointContainer.querySelectorAll(".point").length;

                let newPointHTML = `
                    <div class="flex space-x-4 mb-4 point">
                        <input type="text" name="point[${pointCount}]" value="" 
                            class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="button" class="remove-point text-red-500 hover:text-red-700">
                            削除
                        </button>
                    </div>
                `;
                // ポイントが一つもない場合はタイトル下に追加、ある場合は下に追加
                if (pointContainer.querySelectorAll(".point").length === 0) {
                    pointContainer.insertAdjacentHTML('beforeend', newPointHTML);
                } else {
                    pointContainer.querySelector('.point:last-of-type').insertAdjacentHTML('afterend', newPointHTML);
                }
            });

            // 次のアクション追加ボタン
            document.getElementById("add-action").addEventListener("click", function () {
                let actionContainer = document.getElementById("next-actions");
                let actionCount = actionContainer.querySelectorAll(".next-action").length;

                let newActionHTML = `
                    <div class="flex space-x-4 mb-4 next-action">
                        <input type="text" name="next_action[${actionCount}]" value="" 
                            class="w-full p-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="button" class="remove-action text-red-500 hover:text-red-700">
                            削除
                        </button>
                    </div>
                `;
                // 次のアクションが一つもない場合はタイトル下に追加、ある場合は下に追加
                if (actionContainer.querySelectorAll(".next-action").length === 0) {
                    actionContainer.insertAdjacentHTML('beforeend', newActionHTML);
                } else {
                    actionContainer.querySelector('.next-action:last-of-type').insertAdjacentHTML('afterend', newActionHTML);
                }
            });

            // ポイント削除機能
            document.body.addEventListener("click", function (e) {
                if (e.target && e.target.classList.contains("remove-point")) {
                    e.target.closest(".point").remove();
                }
            });

            // 次のアクション削除機能
            document.body.addEventListener("click", function (e) {
                if (e.target && e.target.classList.contains("remove-action")) {
                    e.target.closest(".next-action").remove();
                }
            });
        });
    </script>
    <script>
        function deleteContentAndRedirect() {
            // 削除フォームを送信
            document.getElementById('delete-form').submit();

            // 少し待ってからリダイレクト (削除が完了するのを待つため)
            setTimeout(function () {
                window.location.href = '{{ route('contents.create') }}';
            }, 500); // 500ms後にリダイレクト
        }
    </script>
</x-app-layout>