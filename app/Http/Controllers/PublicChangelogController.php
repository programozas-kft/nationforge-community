<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicChangelogController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->session()->get('locale', 'hu');
        app()->setLocale($locale);

        return view('public.changelog', compact('locale'));
    }
}
