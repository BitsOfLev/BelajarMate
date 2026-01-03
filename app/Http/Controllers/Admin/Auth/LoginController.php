<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Show admin login page
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Handle admin login
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $user = \App\Models\User::where('email', $credentials['email'])->first();
        if ($user && $user->role !== 'admin') {
            return back()->withErrors([
                'email' => 'This account is not an admin. Please login at the user page.',
            ])->withInput();
        }

        if (! Auth::guard('admin')->attempt(array_merge($credentials, ['role' => 'admin']), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid credentials or not an admin.',
            ])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended('/admin/dashboard');
    }

    // Logout - only affects admin guard
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        // Only invalidate the admin session cookie, not all sessions
        $request->session()->forget('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        
        // Don't call invalidate() as it will destroy all session data
        // Instead, just clear the guard data
        $request->session()->regenerateToken();

        return redirect('/admin');
    }
}



