<?php

namespace App\Http\Controllers;

use App\Models\Content;  // 検索対象のモデルをインポート
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // 検索フォームを表示
    public function index()
    {
        return view('search.index');  // 検索フォームのビューを表示
    }

    // 検索結果を表示
    public function results(Request $request)
    {
        $searchQuery = $request->input('query');  // フォームから送信された検索キーワードを取得

        // データベースを検索して結果を取得
        $contents = Content::where('title', 'like', '%' . $searchQuery . '%')
            ->orWhere('text', 'like', '%' . $searchQuery . '%')
            ->get();

        return view('search.results', compact('contents', 'searchQuery'));  // 結果をビューに渡す
    }
}
