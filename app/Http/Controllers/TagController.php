<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function index()
    {
        $x['tags'] = Tag::all();

        return view('admin.tag.index', $x);
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
        return view('admin.tag.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'tag_name' => 'required|string|max:255|unique:tags,tag_name',
            ],
            [
                'tag_name.required' => 'Nama tag tidak boleh kosong!',
                'tag_name.unique' => 'Nama tag sudah ada!',
            ],
        );

        $tag = Tag::create($validatedData);

        $activity = 'Menambahkan tag baru: ' . $tag->tag_name;
        $this->logActivity($activity);

        return redirect()->route('tag')->with('success', 'Tag berhasil ditambahkan!');
    }

    public function show($id)
    {
        $x['tag'] = Tag::findOrFail($id);

        return view('admin.tag.update', $x);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $request->validate(
            [
                'tag_name' => 'required|string|max:100|unique:tags,tag_name,' . $tag->id . ',id',
            ],
            [
                'tag_name.required' => 'Nama tag tidak boleh kosong!',
                'tag_name.exists' => 'Nama tag sudah ada!',
                'tag_name.unique' => 'Nama tag sudah ada!',
            ],
        );

        $activity = 'Mengubah nama tag: ' . $tag->tag_name . ' → ' . $request->tag_name;
        $this->logActivity($activity);

        $tag->tag_name = $request->tag_name;
        $tag->save();

        return redirect()->route('tag')->with('success', 'Tag berhasil diubah!');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tagName = $tag->tag_name;

        $tag->delete();

        $activity = 'Menghapus tag: ' . $tagName;
        $this->logActivity($activity);

        return redirect()->route('tag')->with('success', 'Tag berhasil dihapus!');
    }
}
