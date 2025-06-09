<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\RateResult;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $bestStaff = RateResult::selectRaw('staff_id, AVG(rate) as avg_rating, COUNT(*) as total_rating')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->groupBy('staff_id')
            ->orderByDesc('avg_rating')
            ->with('staff')
            ->first();

        $staffInfo = $bestStaff ? Staff::find($bestStaff->staff_id) : null;

        return view('index', compact('staffInfo', 'bestStaff', 'now'));
    }
}
