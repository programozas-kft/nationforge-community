<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpArticle;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        $articles = HelpArticle::orderBy('sort_order')->get();
        $articles = HelpArticle::orderBy('sort_order')->get();
        return view('admin.help.index', compact('articles'));
    }

    public function sugo()
    {
        $help_articles = HelpArticle::orderBy('sort_order')->get();
        return view('admin.help.sugo', compact('help_articles'));
    }

    public function update(Request $request, HelpArticle $help)
    {
        $request->validate([
            'title'   => 'required|string|max:200',
            'content' => 'required|string|max:5000',
        ]);

        $help->update($request->only('title', 'content'));

        return redirect()->route('admin.help.index')->with('success', 'Súgó frissítve!');
    }
}
