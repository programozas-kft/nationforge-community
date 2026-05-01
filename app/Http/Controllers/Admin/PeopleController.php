<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PeopleController extends Controller
{
    public function index()
    {
        $people = Person::orderBy('last_name')->paginate(25);
        return view('admin.people.index', compact('people'));
    }

    public function create()
    {
        return view('admin.people.form', ['person' => new Person()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => 'nullable|email|unique:people,email',
            'phone'         => 'nullable|string|max:30',
            'city'          => 'nullable|string|max:100',
            'status'        => 'required|in:prospect,supporter,member,volunteer,donor,vip,inactive',
            'is_subscribed' => 'boolean',
            'notes'         => 'nullable|string',
            'source'        => 'nullable|string|max:100',
            'photo'         => 'nullable|image|max:2048',
        ]);

        $data['is_subscribed'] = $request->boolean('is_subscribed');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = uniqid('p_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/people'), $filename);
            $data['photo'] = 'uploads/people/' . $filename;
        }

        Person::create($data);

        return redirect()->route('admin.people.index')->with('success', 'Kapcsolat sikeresen létrehozva!');
    }

    public function show(Person $person)
    {
        $person->load('donations', 'groups');
        return view('admin.people.show', compact('person'));
    }

    public function edit(Person $person)
    {
        return view('admin.people.form', compact('person'));
    }

    public function update(Request $request, Person $person)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => 'nullable|email|unique:people,email,' . $person->id,
            'phone'         => 'nullable|string|max:30',
            'city'          => 'nullable|string|max:100',
            'status'        => 'required|in:prospect,supporter,member,volunteer,donor,vip,inactive',
            'is_subscribed' => 'boolean',
            'notes'         => 'nullable|string',
            'source'        => 'nullable|string|max:100',
            'photo'         => 'nullable|image|max:2048',
        ]);

        $data['is_subscribed'] = $request->boolean('is_subscribed');

        if ($request->hasFile('photo')) {
            if ($person->photo && file_exists(public_path($person->photo))) {
                File::delete(public_path($person->photo));
            }
            $file = $request->file('photo');
            $filename = uniqid('p_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/people'), $filename);
            $data['photo'] = 'uploads/people/' . $filename;
        }

        $person->update($data);

        return redirect()->route('admin.people.index')->with('success', 'Kapcsolat frissítve!');
    }

    public function destroy(Person $person)
    {
        if ($person->photo && file_exists(public_path($person->photo))) {
            File::delete(public_path($person->photo));
        }
        $person->delete();
        return redirect()->route('admin.people.index')->with('success', 'Kapcsolat törölve!');
    }
}
