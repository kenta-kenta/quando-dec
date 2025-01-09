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
        // バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'point' => 'nullable|array',
            'point.*' => 'nullable|string',
            'next_action' => 'nullable|array',
            'next_action.*' => 'nullable|string',
        ]);


        // コンテンツをidで取得
        $content = Content::findOrFail($id);

        // 元のstructureデータを取得（既存データ）
        $structure = json_decode($content->structure, true);


        // 更新するデータを構造化
        $structure['title'] = $validated['title'];
        $structure['summary'] = $validated['summary'] ?? ''; // 空の値の場合は空文字にする
        $structure['point'] = $validated['point'] ?? []; // ポイントが空の場合は空の配列にする
        $structure['next-action'] = $validated['next_action'] ?? []; // 次のアクションが空の場合は空の配列にする

        // 更新
        $content->update([
            'title' => $validated['title'],
            'structure' => json_encode([
                'summary' => $validated['summary'],
                'point' => $validated['point'] ?? [],
                'next-action' => $validated['next_action'] ?? [],
            ]),
        ]);


        // 更新後、リダイレクト
        return redirect()->route('contents.create');
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
