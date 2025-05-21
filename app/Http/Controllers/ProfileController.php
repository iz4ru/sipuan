<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $x['user'] = Auth::user();

        return view('admin.profile', $x);
    }

    public function logActivity($activity)
    {
        $user = Auth::user();
        $username = $user->username;
        $role = $user->role;

        $log = new Log([
            'username' => $username,
            'activity' => $activity,
            'role' => $role,
        ]);

        $log->save();
    }

    public function update(Request $request, $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        if ($user->id !== Auth::id()) {
            return back()->withErrors('Anda tidak memiliki izin untuk mengedit pengguna ini.');
        }

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'current_password' => 'required',
            ],
            [
                'avatar.max' => 'Ukuran file terlalu besar! Maksimal 2MB.',
                'avatar.image' => 'File yang diunggah bukan gambar!',
                'avatar.mimes' => 'Format gambar tidak valid! Hanya jpeg, png, jpg, gif yang diperbolehkan.',
                'current_password.required' => 'Masukkan password Anda untuk melanjutkan.',
                'name.required' => 'Nama tidak boleh kosong!',
                'email.required' => 'Email tidak boleh kosong!',
                'email.email' => 'Format email tidak valid!',
                'email.unique' => 'Email sudah terdaftar!',
                'username.required' => 'Username tidak boleh kosong!',
                'username.unique' => 'Username sudah terdaftar!',
            ],
        );

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors('Password salah! Perubahan tidak disimpan.');
        }

        if ($request->hasFile('avatar')) {
            try {
                if ($user->avatar && $user->avatar !== 'default.jpg') {
                    Storage::disk('public')->delete('avatars/' . $user->avatar);
                }

                $filename = time() . '.' . $request->avatar->extension();
                $path = $request->file('avatar')->storeAs('avatars', $filename, 'public');

                $user->avatar = $filename;
            } catch (\Exception $e) {
                return back()
                    ->withInput()
                    ->withErrors('Gagal mengunggah gambar: ' . $e->getMessage());
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->save();

        $activity = 'Memperbarui profilnya';
        $this->logActivity($activity);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
