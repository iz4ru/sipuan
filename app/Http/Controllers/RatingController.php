<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Position;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index($uuid)
    {
        $x['staff'] = Staff::where('uuid', $uuid)->withAvg('rateResults', 'rate')->withCount('rateResults')->firstOrFail();

        $x['positions'] = Position::all();

        return view('rate', $x);
    }
}
