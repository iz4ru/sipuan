<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Staff;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    public function index()
    {
        $x['positions'] = Position::all();

        return view('admin.position.index', $x);
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

    public function show($id)
    {
        $x['position'] = Position::findOrFail($id);

        return view('admin.position.update', $x);
    }

    public function update(Request $request, $id)
    {
        $position = Position::findOrFail($id);

        $request->validate(
            [
                'position_name' => 'required|string|max:100|unique:positions,position_name,' . $position->id . ',id',
            ],
            [
                'position_name.required' => 'Nama posisi tidak boleh kosong!',
                'position_name.exists' => 'Nama posisi sudah ada!',
            ],
        );

        $activity = 'Mengubah nama posisi: ' . $position->position_name;
        $this->logActivity($activity);

        $position->position_name = $request->position_name;
        $position->save();

        return redirect()->route('position')->with('success', 'Posisi berhasil diubah!');
    }

    public function destroy($id)
    {
        if (Staff::where('position_id', $id)->exists()) {
            $position = Position::find($id);
            if ($position) {
                $this->logActivity('Gagal menghapus posisi karena masih digunakan: ' . $position->position_name);
            }
            return back()->withErrors([
                'used' => 'Posisi ini masih digunakan oleh staf, tidak bisa dihapus!',
            ]);
        }

        $position = Position::findOrFail($id);
        $positionName = $position->position_name;

        $position->delete();

        $this->logActivity('Menghapus posisi: ' . $positionName);

        return redirect()->route('position')->with('success', 'Posisi berhasil dihapus!');
    }
}
