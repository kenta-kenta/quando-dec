<?php

namespace App\Http\Controllers;

use Gemini\Laravel\Facades\Gemini;

class GeminiController extends Controller
{
    //
    public function show()
    {
        $result = Gemini::geminiPro()->generateContent("Hello");
        $response_text = $result->text();
        return view('contents.gemini', compact('response_text'));
    }
}
