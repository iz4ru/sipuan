<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Staff::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('id_number', 'like', '%' . $search . '%')
                    ->orWhereHas('position', function ($q2) use ($search) {
                        $q2->where('position_name', 'like', '%' . $search . '%');
                    });
            });
        }

        $staffs = $query->withCount('rateResults')->withAvg('rateResults', 'rate')->paginate(9);

        if ($request->wantsJson()) {
            return response()->json($staffs);
        }

        return view('staff', ['staffs' => $staffs]);
    }
}
