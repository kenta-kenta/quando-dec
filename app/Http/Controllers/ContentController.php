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
    public function index()
    {
        // コンテンツ一覧表示
    }

    public function show($id)
    {
        // コンテンツ詳細表示
    }

    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'original_text' => 'required|string',
            'response_text' => 'required|string',
        ]);

        // 構造化データは一旦空のJSONにして保存
        $content = Content::create([
            'text' => $validated['original_text'],
            'structure' => json_encode(['response_text' => $validated['response_text']])
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
        // コンテンツ削除
    }

    public function edit($id)
    {
        // コンテンツ編集フォーム
    }
}
