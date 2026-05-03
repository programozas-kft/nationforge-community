<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::withCount(['people', 'users'])->orderBy('name')->paginate(20);
        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.groups.form', ['group' => new Group()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string',
            'type'        => 'required|in:community,campaign,chapter,committee,team',
            'privacy'     => 'required|in:public,private,secret',
            'is_active'   => 'boolean',
            'icon'        => 'nullable|string|max:50',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['created_by'] = auth()->id();

        Group::create($data);
        return redirect()->route('admin.groups.index')->with('success', 'Csoport létrehozva!');
    }

    public function show(Group $group)
    {
        $group->load(['people', 'users.roles']);
        return view('admin.groups.show', compact('group'));
    }

    public function edit(Group $group)
    {
        return view('admin.groups.form', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string',
            'type'        => 'required|in:community,campaign,chapter,committee,team',
            'privacy'     => 'required|in:public,private,secret',
            'is_active'   => 'boolean',
            'icon'        => 'nullable|string|max:50',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $group->update($data);
        return redirect()->route('admin.groups.show', $group)->with('success', 'Csoport frissítve!');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', 'Csoport törölve!');
    }
}
