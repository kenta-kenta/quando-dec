<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function create()
    {
        // フォームビューを表示
        return view('contents.create');
    }
    public function index(Request $request)
    {
        $query = $request->input('query'); // 検索クエリを取得

        if ($query) {
            // 検索クエリがある場合、検索結果とそれ以外のデータを取得し、作成日が新しい順に並べ替え
            $searchResults = Content::where('title', 'LIKE', '%' . $query . '%')
                ->orderBy('created_at', 'desc') // 作成日が新しい順に並べ替え
                ->paginate(5, ['*'], 'searchPage');

            $otherContents = Content::where('title', 'NOT LIKE', '%' . $query . '%')
                ->orderBy('created_at', 'desc') // 作成日が新しい順に並べ替え
                ->paginate(5, ['*'], 'otherPage');
        } else {
            // クエリがない場合は全てのコンテンツを取得し、作成日が新しい順に並べ替え
            $searchResults = collect(); // 空のコレクション
            $otherContents = Content::orderBy('created_at', 'desc') // 作成日が新しい順に並べ替え
                ->paginate(10);
        }

        // ビューにデータを渡す
        return view('contents.index', compact('searchResults', 'otherContents', 'query'));
    }




    public function show($id)
    {
        $content = Content::findOrFail($id);
        return view('contents.show', compact('content'));
    }

    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'original_text' => 'required|string',
            'response_text' => 'required|string',
        ]);

        // JSONデータをデコード
        $responseData = json_decode($validated['response_text'], true);

        // 構造化データを保存
        $content = Content::create([
            'text' => $validated['original_text'],
            'title' => $responseData['title'],
            'structure' => $validated['response_text'], // オリジナルのJSON文字列を保存
        ]);

        // 保存後、リダイレクト
        return redirect()->route('contents.create')->with('success', 'データが保存されました！');
    }

    public function update(Request $request, $id)
    {
        // コンテンツ更新
    }

    public function destroy($id)
    {
        // コンテンツをidで取得
        $content = Content::findOrFail($id);

        // コンテンツを削除
        $content->delete();

        // 成功メッセージと共にコンテンツ一覧ページにリダイレクト
        return redirect()->route('contents.index')->with('success', 'コンテンツが削除されました。');
    }


    public function edit($id)
    {
        // コンテンツ編集フォーム
    }
}
