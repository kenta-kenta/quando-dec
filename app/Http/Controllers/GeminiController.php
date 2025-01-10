<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;

class GeminiController extends Controller
{
    public function show(Request $request)
    {
        // 入力されたテキストを取得
        $text = $request->input('text');

        // プロンプトを作成
        $prompt = '以下の会話の文字起こしを、指定されたJSON形式で構造化してください。
    議事のポイントと次のアクションは必ず最大4つに絞ってください。

    **JSON形式:**
    {
        "title": "会話のタイトル",
        "summary": 会話の要約文,
        "point": ["会話のポイント1", "会話のポイント2", ...],
        "next-action": ["次のアクション1", "次のアクション2", ...]
    }' . $text;

        try {
            // Gemini APIを呼び出し、レスポンスを受け取る
            $result = Gemini::geminiPro()->generateContent($prompt);
            $response_text = $result->text();

            // ここで、データを保存する
            $responseData = json_decode($response_text, true);


            $content = Content::create([
                'text' => $text,
                'title' => $responseData['title'], // レスポンスからタイトルを取得
                'structure' => $response_text, // オリジナルのJSON文字列を保存
            ]);

            // 保存したデータを再取得（内容を編集するため）
            $savedContent = Content::find($content->id);

            // データベースから取得した情報をビューに渡す
            return view('contents.gemini', [
                'content' => $savedContent, // 保存されたコンテンツ全体を渡す
            ]);
        } catch (\Exception $e) {
            // エラーハンドリング
            return back()->withErrors(['error' => 'Gemini APIでエラーが発生しました。']);
        }
    }




}
