<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Comment;
use App\Models\RateResult;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->input('year', now()->year);

        $staff = Staff::get();
        $comment = Comment::get();
        $rating = RateResult::get();
        $averageRating = RateResult::avg('rate');

        $x['totalStaff'] = count($staff);
        $x['totalRating'] = count($rating);
        $x['avgRating'] = number_format((float) $averageRating, 2, '.', '');
        $x['totalComment'] = count($comment);

        $availableYears = RateResult::selectRaw('YEAR(created_at) as year')->distinct()->orderBy('year', 'desc')->pluck('year')->toArray();

        $ratingsPerMonth = RateResult::selectRaw("MONTH(created_at) as month_num, DATE_FORMAT(created_at, '%b') as month, COUNT(*) as total")->whereYear('created_at', $selectedYear)->groupBy('month_num', 'month')->orderBy('month_num')->get();

        $allMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $totals = [];

        foreach ($allMonths as $index => $month) {
            $found = $ratingsPerMonth->firstWhere('month', $month);
            $totals[] = $found ? $found->total : 0;
        }

        $x['months'] = $allMonths;
        $x['totals'] = $totals;
        $x['availableYears'] = $availableYears;
        $x['selectedYear'] = $selectedYear;

        return view('admin.dashboard', $x);
    }
}
