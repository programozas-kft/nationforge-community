<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InviteRegistrationController extends Controller
{
    public function show(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if (!$invitation->isPending()) {
            return view('invite.expired', compact('invitation'));
        }

        return view('invite.register', compact('invitation'));
    }

    public function register(Request $request, string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if (!$invitation->isPending()) {
            return redirect()->route('invite.register', $token);
        }

        $request->validate([
            'name'     => 'required|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $invitation->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($invitation->role);

        $invitation->update(['used_at' => now()]);

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }
}
