<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemoLoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $email = config('app.demo_user_email');

        if (!$email) {
            abort(404);
        }

        $user = User::where('email', $email)->first();

        if (!$user || !$user->isAdmin()) {
            abort(404);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }
}
