<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Staff;
use App\Models\Comment;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request as FacadeRequest;

class RatingController extends Controller
{
    public function index($uuid)
    {
        $staff = Staff::where('uuid', $uuid)->withAvg('rateResults', 'rate')->withCount('rateResults')->firstOrFail();

        $x['staff'] = $staff;
        $x['positions'] = Position::all();
        $x['tags'] = Tag::pluck('tag_name');

        $cleanPhone = preg_replace('/^0/', '62', $staff->phone);
        $x['whatsappNumber'] = 'https://wa.me/' . $cleanPhone;
        $x['staffEmail'] = 'https://mail.google.com/mail/u/0/?fs=1&to=' . $staff->email . '&su=&body=&tf=cm';

        return view('rate', $x);
    }

    public function store(Request $request, $uuid)
    {
        $now = Carbon::now('Asia/Jakarta'); 
        $start = Carbon::createFromTime(8, 0, 0);
        $end = Carbon::createFromTime(15, 0, 0);

        if (!$now->between($start, $end)) {
            return redirect()
                ->back()
                ->withErrors([
                    'error' => 'Rating hanya bisa dilakukan antara jam 08:00 sampai 15:00.',
                ]);
        }

        $request->validate(
            [
                'rate' => 'required|numeric|min:1|max:5',
                'comment' => 'nullable|string',
                'tags' => 'array',
                'tags.*' => 'string|distinct|max:50',
            ],
            [
                'rate.required' => 'Rating tidak boleh kosong!',
                'rate.min' => 'Rating tidak boleh kosong!',
                'rate.max' => 'Rating maksimal 5!',
                'comment.string' => 'Komentar harus berupa teks!',
            ],
        );

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

            $pivotData = [];
            foreach ($tags as $tagId) {
                $pivotData[$tagId] = ['staff_id' => $staff->id];
            }

            $rateResult->tags()->attach($pivotData);
        }

        return redirect()->back()->with('success', 'Rating telah sukses dilakukan!');
    }

    // public function store(Request $request, $uuid)
    // {
    //     $staff = Staff::where('uuid', $uuid)->firstOrFail();
    //     $userIp = $request->ip(); // atau bisa pakai auth()->id() kalau ada login

    //     $cacheKey = "rating:{$staff->id}:{$userIp}";
    //     $diffMinutes = 30;

    //     if (Cache::has($cacheKey)) {
    //         $nextAllowedTime = Carbon::parse(Cache::get($cacheKey . '_expires_at'));

    //         $diff = $nextAllowedTime->diffForHumans(now(), [
    //             'syntax' => Carbon::DIFF_RELATIVE_TO_NOW,
    //             'parts' => 2,
    //             'short' => true,
    //         ]);

    //         return redirect()
    //             ->back()
    //             ->withErrors(['error' => 'Kamu sudah memberi rating. Coba lagi ' . $diff]);
    //     }

    //     $request->validate([
    //         'rate' => 'required|numeric|min:1|max:5',
    //         'comment' => 'nullable|string',
    //         'tags' => 'array',
    //         'tags.*' => 'string|distinct|max:50',
    //     ]);

    //     $comment = null;
    //     if ($request->filled('comment')) {
    //         $comment = Comment::create([
    //             'staff_id' => $staff->id,
    //             'comment' => $request->comment,
    //         ]);
    //     }

    //     $rateResult = $staff->rateResults()->create([
    //         'comment_id' => $comment?->id,
    //         'position_id' => $staff->position_id,
    //         'rate' => $request->rate,
    //     ]);

    //     if ($request->has('tags')) {
    //         $tags = Tag::whereIn('tag_name', $request->tags)->pluck('id');
    //         $rateResult->tags()->sync($tags);
    //     }

    //     $expiresAt = now()->addMinutes($diffMinutes);
    //     Cache::put($cacheKey, true, $expiresAt);
    //     Cache::put($cacheKey . '_expires_at', $expiresAt, $expiresAt);

    //     return redirect()->back()->with('success', 'Rating telah sukses dilakukan!');
    // }
}
