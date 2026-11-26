<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.products.index');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginInput = trim($request->input('username'));
        $password   = $request->input('password');
        $remember   = $request->boolean('remember');

        $hasUsernameColumn = Schema::hasColumn('users', 'username');

        // Cari user berdasarkan username atau email
        $user = null;
        if ($hasUsernameColumn) {
            $user = User::where('username', $loginInput)
                ->orWhere('email', $loginInput)
                ->first();
        } else {
            $user = User::where('email', $loginInput)->first();
        }

        // Fallback jika input 'abi_admin' dan kolom username belum ada
        if (!$user && $loginInput === 'abi_admin') {
            $user = User::where('email', 'abi_admin@giftora.com')
                ->orWhere('email', 'admin@giftora.com')
                ->first();
        }

        // Jika user belum pernah dibuat sama sekali (belum seed), otomatis buat akun
        if (!$user && $loginInput === 'abi_admin' && $password === 'prasetio') {
            $createData = [
                'name'     => 'Abi Prasetio',
                'email'    => 'abi_admin@giftora.com',
                'password' => Hash::make('prasetio'),
            ];
            if ($hasUsernameColumn) {
                $createData['username'] = 'abi_admin';
            }
            $user = User::create($createData);
        }

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();

            return redirect()->intended(route('admin.products.index'))
                ->with('success', 'Selamat datang kembali di Panel Admin, ' . $user->name . '!');
        }

        return back()
            ->withErrors(['username' => 'Username atau kata sandi yang Anda masukkan salah.'])
            ->onlyInput('username');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Anda telah berhasil keluar dari Panel Admin.');
    }
}
