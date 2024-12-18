<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
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
        // 新規コンテンツ作成
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
