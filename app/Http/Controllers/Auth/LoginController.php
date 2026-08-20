<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Tampilkan form login
    public function create()
    {
        return view('auth.login');
    }

    // Proses login
    public function store(Request $request)
    {
        $request->validate([
            'nipp' => ['required', 'string', 'min:4', 'max:25', 'regex:/^[0-9A-Za-z]+$/'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'nipp.required' => 'NIPP wajib diisi.',
            'nipp.min' => 'NIPP minimal 4 karakter.',
            'nipp.max' => 'NIPP maksimal 25 karakter.',
            'nipp.regex' => 'NIPP hanya boleh berisi huruf dan angka, tanpa spasi atau simbol.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $credentials = $request->only('nipp', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Pesan generik (gak nyebut "NIPP salah" atau "password salah" spesifik)
        // biar gak jadi celah orang lain bisa nebak-nebak NIPP mana yang valid.
        return back()
            ->withErrors(['nipp' => 'NIPP atau password yang Anda masukkan salah.'])
            ->onlyInput('nipp');
    }

    // Proses logout
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}