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
        $validated = $request->validate([
            'text' => 'required|string',
        ]);

        $text = $request->input('text');

        // プロンプトの作成
        $prompt = '・文字数指定なし
                   ・箇条書きなどを用いて積極的に構造化
                   ・タイトルとまとめをつけて
                   この三つのルールで以下の文章を要約してください。' . $text;

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
