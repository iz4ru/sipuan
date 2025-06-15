<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function index()
    {
        $x['adminExists'] = User::where('role', 'admin')->exists();

        return view('auth.login', $x);
    }

    public function registerFirstAdmin()
    {
        $adminExists = User::where('role', 'admin')->exists();

        if ($adminExists) {
            return redirect()
                ->route('admin.login')
                ->withErrors(['error' => 'Admin sudah terdaftar! Silakan login dengan akun yang ada.']);
        }

        return view('auth.register');
    }

    public function storeFirstAdmin(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'name.required' => 'Nama tidak boleh kosong!',
                'email.required' => 'Email tidak boleh kosong!',
                'email.unique' => 'Email sudah terdaftar!',
                'password.required' => 'Password tidak boleh kosong!',
                'password.confirmed' => 'Konfirmasi password tidak sesuai!',
                'password.min' => 'Password minimal 8 karakter!',
                'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong!',
                'password_confirmation.min' => 'Konfirmasi password minimal 8 karakter!',
                'password_confirmation.confirmed' => 'Konfirmasi password tidak sesuai!',
            ],
        );

        $baseUsername = Str::slug($request->name, '');
        $username = $baseUsername;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '' . $counter;
            $counter++;
        }

        $validatedData['username'] = $username;

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'username' => $username,
            'password' => Hash::make($validatedData['password']),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.login')->with('success', 'Akun admin berhasil dibuat! Silahkan login dengan akun yang baru saja dibuat.');
    }

    public function loginAction(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()
                ->intended('dashboard')
                ->with('success', 'Login berhasil, selamat datang kembali ' . Auth::user()->name . ' !');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau Password yang Anda masukkan salah !',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Logout berhasil, sampai jumpa lagi!');
    }
}
