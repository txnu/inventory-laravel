<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();

                Log::info('User login success', [
                    'user' => Auth::user(),
                    'session_id' => session()->getId()
                ]);

                return redirect("/dashboard")->with('success', 'Login successful! Welcome back.');
            }


            return back()->withInput($request->only('email'))
                ->with('error', 'Email atau password salah. Silakan coba lagi.');
        } catch (\Exception $e) {
            Log::error('AuthController Exception: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()->withInput($request->only('email'))
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
