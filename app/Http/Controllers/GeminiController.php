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
        $prompt = $text . 'について説明してください。';

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
