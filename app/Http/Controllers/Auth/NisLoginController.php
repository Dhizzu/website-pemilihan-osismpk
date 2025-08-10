<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class NisLoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.nis-login');
    }

    /**
     * Handle login with NIS and token.
     */
    public function login(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
            'login_token' => 'required|string',
        ]);

        $user = User::where('nis', $request->nis)
                    ->where('login_token', $request->login_token)
                    ->first();

        if ($user) {
            Auth::login($user);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'nis' => 'Invalid NIS or login token.',
        ]);
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
