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
        return view('admin.help.index', compact('articles'));
    }

    public function sugo()
    {
        $help_articles = HelpArticle::orderBy('sort_order')->get();
        $locale = app()->getLocale();
        return view('admin.help.sugo', compact('help_articles', 'locale'));
    }

    public function update(Request $request, HelpArticle $help)
    {
        $request->validate([
            'title'      => 'required|string|max:200',
            'content'    => 'required|string|max:10000',
            'title_en'   => 'nullable|string|max:200',
            'content_en' => 'nullable|string|max:10000',
            'title_de'   => 'nullable|string|max:200',
            'content_de' => 'nullable|string|max:10000',
            'title_ro'   => 'nullable|string|max:200',
            'content_ro' => 'nullable|string|max:10000',
            'title_sk'   => 'nullable|string|max:200',
            'content_sk' => 'nullable|string|max:10000',
            'video_url'  => 'nullable|url|max:500',
        ]);

        $help->update($request->only(
            'title', 'content',
            'title_en', 'content_en',
            'title_de', 'content_de',
            'title_ro', 'content_ro',
            'title_sk', 'content_sk',
            'video_url'
        ));

        return redirect()->route('admin.help.index')->with('success', __('help.updated'));
    }
}
