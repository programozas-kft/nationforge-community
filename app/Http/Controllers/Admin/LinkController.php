<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::orderBy('sort_order')->orderBy('title')->get();
        $grouped = $links->where('is_active', true)->groupBy(fn($l) => $l->category ?: 'Egyéb');
        return view('admin.links.index', compact('links', 'grouped'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:100',
            'url'         => 'required|url|max:500',
            'description' => 'nullable|string|max:300',
            'category'    => 'nullable|string|max:80',
            'color'       => 'nullable|string|max:20',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'boolean',
        ]);
        $data['is_active']  = $request->boolean('is_active', true);
        $data['color']      = $data['color'] ?? '#405189';
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Link::create($data);
        return redirect()->route('admin.settings')->with('success', 'Link hozzáadva!');
    }

    public function update(Request $request, Link $link)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:100',
            'url'         => 'required|url|max:500',
            'description' => 'nullable|string|max:300',
            'category'    => 'nullable|string|max:80',
            'color'       => 'nullable|string|max:20',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'boolean',
        ]);
        $data['is_active']  = $request->boolean('is_active');
        $data['color']      = $data['color'] ?? '#405189';
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $link->update($data);
        return redirect()->route('admin.settings')->with('success', 'Link frissítve!');
    }

    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->route('admin.settings')->with('success', 'Link törölve!');
    }
}
