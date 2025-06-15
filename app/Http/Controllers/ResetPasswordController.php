<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.required' => 'Email tidak boleh kosong!',
                'email.email' => 'Format email tidak valid!',
                'email.exists' => 'Email tidak sesuai!',
            ],
        );

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT ? back()->with('success', 'Link reset password telah dikirim ke email Anda.') : back()->withErrors(['email' => 'Gagal mengirim link reset password. Silakan coba lagi.']);
    }

    public function resetForm($token, Request $request)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        if ($request->password !== $request->password_confirmation) {
            return back()->withErrors([
                'password_confirmation' => 'Password baru dan konfirmasi password tidak sesuai!',
            ]);
        } elseif (Str::length($request->password) < 8) {
            return back()->withErrors([
                'password_confirmation' => 'Password baru minimal 8 karakter!',
            ]);
        }

        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8|same:password',
                'token' => 'required|string',
            ],
            [
                'email.required' => 'Email tidak boleh kosong!',
                'email.email' => 'Format email tidak valid!',
                'email.exists' => 'Email tidak sesuai!',
                'password.required' => 'Password tidak boleh kosong!',
                'password.min' => 'Password minimal 8 karakter!',
                'password.confirmed' => 'Konfirmasi password tidak sesuai!',
            ],
        );

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function (User $user, string $password) {
            $user
                ->forceFill([
                    'password' => Hash::make($password),
                ])
                ->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET ? redirect()->route('admin.login')->with('success', 'Password berhasil direset. Silahkan untuk masuk!') : back()->withErrors(['email' => 'Gagal mereset password. Silakan coba lagi.']);
    }
}
