<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;

class GeminiController extends Controller
{
    //
    public function show(Request $request)
    {
        $text = $request->input('text');

        // プロンプトの作成
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
            $result = Gemini::geminiPro()->generateContent($prompt);
            $response_text = $result->text();

            return view('contents.gemini', [
                'original_text' => $text,
                'response_text' => $response_text,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gemini APIでエラーが発生しました。']);
        }
    }
}
