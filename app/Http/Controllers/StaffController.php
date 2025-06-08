<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Tag;
use App\Models\Staff;
use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Staff::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('id_number', 'like', '%' . $search . '%')
                    ->orWhereHas('position', function ($q2) use ($search) {
                        $q2->where('position_name', 'like', '%' . $search . '%');
                    });
            });
        }

        $staffs = $query->with('position')->withAvg('rateResults', 'rate')->withCount('rateResults')->get();

        if ($request->wantsJson()) {
            $staffs = $query->with('position')->get();
        } else {
            $staffs = $query->get();
        }

        return view('admin.staff.index', ['staffs' => $staffs]);
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
        $x['positions'] = Position::all();

        return view('admin.staff.create', $x);
    }

    public function store(Request $request)
    {
        $activity = 'Membuat staff baru';
        $this->logActivity($activity);

        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:staffs',
                'image' => 'required|image|mimes:png,jpg,jpeg|max:2048', // Standardized to 2MB
                'id_number' => 'required|string|max:255',
                'sex' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'position_name' => 'required|string|max:255',
            ],
            [
                'image.max' => 'Ukuran file terlalu besar! Maksimal 2MB.',
                'image.image' => 'File yang diunggah bukan gambar!',
                'image.mimes' => 'Format gambar tidak valid! Hanya png, jpg, jpeg yang diperbolehkan.',
                'name.required' => 'Nama tidak boleh kosong!',
                'email.required' => 'Email tidak boleh kosong!',
                'email.email' => 'Format email tidak valid!',
                'email.unique' => 'Email sudah terdaftar!',
                'id_number.required' => 'Nomor identitas tidak boleh kosong!',
                'position_name.required' => 'Bidang tidak boleh kosong!',
            ],
        );

        $position = Position::create([
            'position_name' => $validated['position_name'],
        ]);

        $staff = new Staff();
        $staff->name = $validated['name'];
        $staff->email = $validated['email'];
        $staff->id_number = $validated['id_number'];
        $staff->sex = $validated['sex'];
        $staff->phone = $validated['phone'];
        $staff->position_id = $position->id;

        if ($request->hasFile('image')) {
            try {
                $filename = time() . '.' . $request->image->extension();
                $path = $request->file('image')->storeAs('images', $filename, 'public');

                $staff->image = $filename;
            } catch (\Exception $e) {
                return back()
                    ->withInput()
                    ->withErrors(['failed' => 'Gagal mengunggah gambar: ' . $e->getMessage()]);
            }
        }

        $staff->save();

        return redirect()->route('staff.mgmt')->with('success', 'Staff berhasil ditambahkan!');
    }

    public function show($uuid)
    {
        $x['staff'] = Staff::where('uuid', $uuid)->firstOrFail();
        $x['positions'] = Position::all();

        return view('admin.staff.update', $x);
    }

    public function update(Request $request, $uuid)
    {
        $staff = Staff::where('uuid', $uuid)->firstOrFail();

        $activity = 'Memperbarui data staf';
        $this->logActivity($activity);

        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:staffs,email,' . $staff->id,
                'image' => 'image|mimes:png,jpg,jpeg|max:2048', // Standardized to 2MB
                'id_number' => 'required|string|max:255',
                'sex' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'position_id' => 'required',
            ],
            [
                'image.max' => 'Ukuran file terlalu besar! Maksimal 2MB.',
                'image.image' => 'File yang diunggah bukan gambar!',
                'image.mimes' => 'Format gambar tidak valid! Hanya png, jpg, jpeg yang diperbolehkan.',
                'name.required' => 'Nama tidak boleh kosong!',
                'email.required' => 'Email tidak boleh kosong!',
                'email.email' => 'Format email tidak valid!',
                'email.unique' => 'Email sudah terdaftar!',
                'as_who.required' => 'Sebagai siapa tidak boleh kosong!',
                'id_number.required' => 'Nomor identitas tidak boleh kosong!',
                'position_id.required' => 'Bidang tidak boleh kosong!',
            ],
        );

        $staff->name = $validated['name'];
        $staff->email = $validated['email'];
        $staff->id_number = $validated['id_number'];
        $staff->sex = $validated['sex'];
        $staff->phone = $validated['phone'];
        $staff->position_id = $validated['position_id'];

        if ($request->hasFile('image')) {
            try {
                if ($staff->image) {
                    Storage::disk('public')->delete('images/' . $staff->image);
                }

                $filename = time() . '.' . $request->image->extension();
                $path = $request->file('image')->storeAs('images', $filename, 'public');

                $staff->image = $filename;
            } catch (\Exception $e) {
                return back()
                    ->withInput()
                    ->withErrors(['failed' => 'Gagal mengunggah gambar: ' . $e->getMessage()]);
            }
        }

        $staff->save();

        return redirect()->route('staff.mgmt')->with('success', 'Staf telah berhasil diperbarui!');
    }

    public function preview($uuid)
    {
        $x['staff'] = Staff::where('uuid', $uuid)
            ->with(['rateResults', 'tags'])
            ->withAvg('rateResults', 'rate')
            ->withCount('rateResults')
            ->firstOrFail();

        $x['totalTags'] = $x['staff']->tags->count();
        $x['totalComments'] = $x['staff']->comments->count();

        // Load initial comments (first 5) dengan full text untuk JavaScript
        $x['initialComments'] = $x['staff']
            ->comments()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'comment_preview' => Str::limit($comment->comment, 150, '...'),
                    'is_long' => strlen($comment->comment) > 150,
                    'created_at' => $comment->created_at,
                ];
            });

        $allTags = Tag::all();

        $x['tagCounts'] = $allTags
            ->map(function ($tag) use ($x) {
                $count = $x['staff']->tags->where('id', $tag->id)->count();

                return [
                    'id' => $tag->id,
                    'tag_name' => $tag->tag_name,
                    'total' => $count,
                ];
            })
            ->sortByDesc('total')
            ->values();

        $x['positions'] = Position::all();
        $x['tags'] = Tag::all();

        return view('admin.staff.preview', $x);
    }

    public function loadComments($uuid)
    {
        $staff = Staff::where('uuid', $uuid)->firstOrFail();

        $page = request('page', 1);
        $perPage = request('per_page', 5);
        $offset = ($page - 1) * $perPage;

        $comments = $staff
            ->comments()
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($perPage)
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'comment_preview' => Str::limit($comment->comment, 150, '...'),
                    'is_long' => strlen($comment->comment) > 150,
                    'created_at' => $comment->created_at,
                ];
            });

        $hasMore = $staff->comments()->count() > $offset + $perPage;

        return response()->json([
            'comments' => $comments,
            'hasMore' => $hasMore,
            'nextPage' => $page + 1,
        ]);
    }

    public function destroy(Request $request, $uuid)
    {
        $staff = Staff::where('uuid', $uuid)->firstOrFail();

        $activity = 'Menghapus staf';
        $this->logActivity($activity);

        $request->validate(
            [
                'password_confirmation' => 'required',
            ],
            [
                'password_confirmation.required' => 'Password konfirmasi tidak boleh kosong!',
            ],
        );

        if (!Hash::check($request->password_confirmation, Auth::user()->password)) {
            return back()->withErrors([
                'password_confirmation' => 'Password konfirmasi tidak sesuai!',
            ]);
        }

        if ($staff->image) {
            Storage::disk('public')->delete('images/' . $staff->image);
        }

        $staff->delete();

        return redirect()->route('staff.mgmt')->with('success', 'Staff berhasil dihapus!');
    }
}
