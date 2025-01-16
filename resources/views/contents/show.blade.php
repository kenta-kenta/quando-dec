<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg relative">
                <div class="p-6 text-gray-900">
                    <!-- 一覧に戻るリンク -->
                    <a href="{{ route('contents.index') }}"
                        class="text-blue-500 hover:text-blue-700 mb-4 inline-block">一覧に戻る</a>

                    <!-- タイトル -->
                    <h3 class="text-2xl font-semibold text-gray-800">{{ $content->title }}</h3>

                    <!-- 作成日・更新日 -->
                    <div class="mt-4 text-gray-600">
                        <p class="text-sm">作成日: {{ $content->created_at->format('Y-m-d H:i') }}</p>
                        <p class="text-sm">更新日: {{ $content->updated_at->format('Y-m-d H:i') }}</p>
                    </div>

                    <!-- 構造化データ -->
                    <div class="mt-6">
                        <h4 class="text-lg font-medium text-gray-800">構造化データ</h4>
                        <div class="mt-2 p-4 bg-gray-100 rounded-lg">
                            @php
                            $structure = json_decode($content->structure, true);
                            @endphp

                            @if ($structure)
                            <!-- 要約 -->
                            @if (isset($structure['summary']))
                            <div class="mb-4">
                                <h5 class="font-semibold text-gray-700">要約：</h5>
                                <p class="text-gray-800 leading-relaxed">{{ $structure['summary'] }}
                                </p>
                            </div>
                            @endif

                            <!-- ポイント -->
                            @if (isset($structure['point']))
                            <div class="mb-4">
                                <h5 class="font-semibold text-gray-700">ポイント：</h5>
                                <ul class="list-disc pl-5">
                                    @foreach ($structure['point'] as $point)
                                    <li class="text-gray-800">{{ $point }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <!-- 次のアクション -->
                            @if (isset($structure['next-action']))
                            <div class="mb-4">
                                <h5 class="font-semibold text-gray-700">次のアクション：</h5>
                                <ul class="list-disc pl-5">
                                    @foreach ($structure['next-action'] as $action)
                                    <li class="text-gray-800">{{ $action }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @else
                            <p class="text-gray-800">構造化データがありません。</p>
                            @endif
                        </div>
                    </div>

                    <!-- 元データ -->
                    <div class="mt-6">
                        <h4 class="text-lg font-medium text-gray-800">元データ</h4>
                        <div class="mt-2 p-4 bg-gray-100 rounded-lg">
                            <p class="text-gray-800">{{ $content->text }}</p>
                        </div>
                    </div>

                    <!-- 削除ボタン -->
                    <div class="flex mt-6">
                        <form action="{{ route('contents.destroy', $content->id) }}" method="POST"
                            onsubmit="return confirm('本当に削除しますか？');" class="absolute top-4 right-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">削除</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>