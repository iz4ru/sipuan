<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Comment;
use App\Models\RateResult;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $staff = Staff::get();
        $comment = Comment::get();
        $rating = RateResult::get();
        $averageRating = RateResult::avg('rate');

        $x['totalStaff'] = count($staff);
        $x['totalRating'] = count($rating);
        $x['avgRating'] = number_format((float) $averageRating, 2, '.', '');
        $x['totalComment'] = count($comment);

        $ratingsPerMonth = RateResult::selectRaw("DATE_FORMAT(created_at, '%b %Y') as month, COUNT(*) as total")
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->get();

        $x['months'] = $ratingsPerMonth->pluck('month');
        $x['totals'] = $ratingsPerMonth->pluck('total');

        return view('admin.dashboard', $x);
    }
}
