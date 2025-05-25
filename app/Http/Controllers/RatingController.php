<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Staff;
use App\Models\Comment;
use App\Models\Position;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index($uuid)
    {
        $x['staff'] = Staff::where('uuid', $uuid)->withAvg('rateResults', 'rate')->withCount('rateResults')->firstOrFail();

        $x['positions'] = Position::all();
        $x['tags'] = Tag::pluck('tag_name');

        return view('rate', $x);
    }

    public function store(Request $request, $uuid)
    {
        $request->validate([
            'rate' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:255',
            'tags' => 'array',
            'tags.*' => 'string|distinct|max:50',
        ]);

        $staff = Staff::where('uuid', $uuid)->firstOrFail();

        $comment = null;
        if ($request->filled('comment')) {
            $comment = Comment::create([
                'staff_id' => $staff->id,
                'comment' => $request->comment,
            ]);
        }

        $rateResult = $staff->rateResults()->create([
            'comment_id' => $comment?->id,
            'position_id' => $staff->position_id,
            'rate' => $request->rate,
        ]);

        if ($request->has('tags')) {
            $tags = Tag::whereIn('tag_name', $request->tags)->pluck('id');
            $rateResult->tags()->sync($tags);
        }

        return redirect()->back()->with('success', 'Rating telah sukses dilakukan!');
    }
}
