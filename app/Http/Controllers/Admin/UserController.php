<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'groups'])->orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        $groups = \App\Models\Group::orderBy('name')->get();
        return view('admin.users.index', compact('users', 'roles', 'groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            'role'      => 'required|exists:roles,name',
            'photo'     => 'nullable|image|max:2048',
            'groups'    => 'nullable|array',
            'groups.*'  => 'exists:groups,id',
        ]);

        $userData = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ];

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = uniqid('u_') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/users', $filename, 'public');
            $userData['photo'] = 'uploads/users/' . $filename;
        }

        $user = User::create($userData);
        $user->assignRole($request->role);
        
        if ($request->has('groups')) {
            $user->groups()->sync($request->groups);
        }

        return redirect()->route('admin.users.index')->with('success', 'Felhasználó létrehozva!');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:8|confirmed',
            'role'      => 'required|exists:roles,name',
            'photo'     => 'nullable|image|max:2048',
            'groups'    => 'nullable|array',
            'groups.*'  => 'exists:groups,id',
        ]);

        $userData = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if (filled($request->password)) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $file = $request->file('photo');
            $filename = uniqid('u_') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/users', $filename, 'public');
            $userData['photo'] = 'uploads/users/' . $filename;
        }

        $user->update($userData);
        $user->syncRoles([$request->role]);
        
        if ($request->has('groups')) {
            $user->groups()->sync($request->groups);
        } else {
            $user->groups()->sync([]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Felhasználó frissítve!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Saját magadat nem törölheted!');
        }
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Felhasználó törölve!');
    }
}
