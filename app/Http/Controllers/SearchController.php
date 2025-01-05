<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query');

        // タイトルで検索
        $contents = Content::where('title', 'like', '%' . $query . '%')->paginate(10);

        return view('search.index', compact('contents', 'query'));
    }
}