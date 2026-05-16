<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InvitationMail;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email|unique:invitations,email',
            'role'  => 'required|exists:roles,name',
        ]);

        // Remove any old (expired/unused) invitation for this email
        Invitation::where('email', $request->email)->whereNull('used_at')->delete();

        $invitation = Invitation::generate($request->email, $request->role);

        Mail::to($invitation->email)->send(new InvitationMail($invitation));

        return redirect()->route('admin.users.index')
            ->with('success', __('users.invite_sent', ['email' => $invitation->email]));
    }

    public function resend(Invitation $invitation)
    {
        if (!$invitation->isPending()) {
            return redirect()->route('admin.users.index')->with('error', __('users.invite_not_resendable'));
        }

        // Extend expiry and regenerate token on resend
        $invitation->update([
            'expires_at' => now()->addDays(7),
        ]);

        Mail::to($invitation->email)->send(new InvitationMail($invitation));

        return redirect()->route('admin.users.index')
            ->with('success', __('users.invite_resent', ['email' => $invitation->email]));
    }

    public function destroy(Invitation $invitation)
    {
        $invitation->delete();
        return redirect()->route('admin.users.index')->with('success', __('users.invite_deleted'));
    }
}
