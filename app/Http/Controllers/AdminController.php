<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $x['users'] = User::where('id', '!=', Auth::id())->get();

        return view('admin.management.index', $x);
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

    public function create()
    {
        return view('admin.management.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required',
            ],
            [
                'role.required' => 'Pilih role pengguna',
                'name.required' => 'Nama tidak boleh kosong!',
                'email.required' => 'Email tidak boleh kosong!',
                'email.unique' => 'Email sudah terdaftar!',
                'password.required' => 'Password tidak boleh kosong!',
                'password.confirmed' => 'Konfirmasi password tidak sesuai!',
                'password.min' => 'Password minimal 8 karakter!',
                'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong!',
                'password_confirmation.min' => 'Konfirmasi password minimal 8 karakter!',
                'password_confirmation.confirmed' => 'Konfirmasi password tidak sesuai!',
            ]
        );

        $activity = 'Membuat user baru';
        $this->logActivity($activity);

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
            'role' => $validatedData['role'],
        ]);

        return redirect()->route('admin.mgmt')->with('success', 'User berhasil ditambahkan!');
    }

    public function show($uuid)
    {
        $x['user'] = User::where('uuid', $uuid)->firstOrFail();

        return view('admin.management.update', $x);
    }

    public function update(Request $request, $uuid)
    {
        $users = User::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $users->id,
            'username' => 'required|string|max:255|unique:users,username,' . $users->id,
        ], [
            'name.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.unique' => 'Email sudah terdaftar!',
            'username.required' => 'Username tidak boleh kosong!',
            'username.unique' => 'Username sudah terdaftar!',
        ]);  

        $noneChanged = User::where('name', $request->name)
            ->where('email', $request->email)
            ->where('username', $request->username)
            ->where('uuid', '!=', $uuid)
            ->exists();

        if ($noneChanged) {
            return back()->withErrors([
                'all' => 'Data yang Anda masukkan sudah ada, tidak ada perubahan yang dibuat!'
            ]);
        }      

        $activity = 'Mengupdate data user';
        $this->logActivity($activity);

        $users->name = $request->name;
        $users->email = $request->email;
        $users->username = $request->username;
        $users->save();

        return redirect()->route('admin.mgmt')->with('success', 'User berhasil diupdate!');
    }

    public function destroy(Request $request, $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        $userCount = User::where('role', 'admin')->count();

        if ($userCount <= 1 && $user->role === 'admin') {
            return redirect()->back()->withErrors([
                'delete' => 'Tidak bisa menghapus user admin terakhir!',
            ]);
        }

        $request->validate([
            'password_confirmation' => 'required',
        ]);

        if (!Hash::check($request->password_confirmation, $user->password)) {
            return back()->withErrors([
                'password_confirmation' => 'Password konfirmasi tidak sesuai!',
            ]);
        }

        $activity = 'Menghapus user';
        $this->logActivity($activity);

        $user->delete();

        return redirect()->route('admin.mgmt')->with('success', 'User berhasil dihapus!');
    }

    public function editPassword($uuid)
    {
        $x['user'] = User::where('uuid', $uuid)->firstOrFail();

        return view('admin.management.change_password', $x);
    }

    public function updatePassword(Request $request, $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        if ($request->password !== $request->password_confirmation)
        {
            return back()->withErrors([
                'password_confirmation' => 'Password baru dan konfirmasi password tidak sesuai!',
            ]);
        } elseif (Str::length($request->password) < 8)
        {
            return back()->withErrors([
                'password_confirmation' => 'Password baru minimal 8 karakter!',
            ]);
        }

        $activity = 'Update password user';
        $this->logActivity($activity);

        $request->validate([
            'password_current' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ],
        [
            'password_current.required' => 'Password saat ini tidak boleh kosong!',
            'password.required' => 'Password baru tidak boleh kosong!',
            'password_confirmation.required' => 'Konfirmasi password baru tidak boleh kosong!',
        ]);

        if (!Hash::check($request->password_current, $user->password))
        {
            return back()->withErrors([
                'password_current' => 'Password saat ini tidak sesuai!',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.mgmt')->with('success', 'Password berhasil diubah!');
    }
}
