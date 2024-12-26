    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-bold mb-4">Geminiからの応答</h2>

                    @if(isset($response_text))
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                        {!! nl2br(e($response_text)) !!}
                    </div>
                    @else
                    <p>応答がありません。</p>
                    @endif
                </div>
            </div>
        </div>
    </div>