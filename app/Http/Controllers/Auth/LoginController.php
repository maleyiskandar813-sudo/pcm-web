<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && ! $user->is_active) {
            return back()->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi Ketua PCM.'])->onlyInput('email');
        }

        if ($user && ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['password' => 'Password salah. Silakan coba lagi.'])->onlyInput('email');
        }

        if (! auth()->attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email tidak terdaftar. Periksa kembali atau hubungi Ketua PCM.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
