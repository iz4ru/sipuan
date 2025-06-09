<?php

namespace Database\Seeders;

use App\Models\RateResult;
use App\Models\Staff;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RateResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $staffIds = Staff::pluck('id')->toArray();

        foreach (range(0, 11) as $i) {
            $month = Carbon::now()->subMonths($i);

            foreach ($staffIds as $staffId) {
                RateResult::create([
                    'staff_id' => $staffId,
                    'rate' => rand(1, 5),
                    'created_at' => $month->copy()->startOfMonth()->addDays(rand(0, 25)),
                    'updated_at' => $month->copy()->endOfMonth(),
                ]);
            }
        }
    }
}
