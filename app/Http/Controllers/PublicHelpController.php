<?php

namespace App\Http\Controllers;

use App\Models\HelpArticle;
use Illuminate\Http\Request;

class PublicHelpController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->session()->get('locale', 'hu');
        app()->setLocale($locale);

        $help_articles = HelpArticle::orderBy('sort_order')->get();

        return view('admin.help.sugo', compact('help_articles', 'locale'));
    }
}
