<?php

namespace App\Http\Controllers;

use App\Enums\DaysEnum;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class _SiteController extends Controller
{
    public function __invoke()
    {
        try {

            for ($i=1; $i <= 30; $i++) { 
                $schedule=Schedule::inRandomOrder()->first();
                $schedule->taken=true;
                $schedule->save();
            }
            //  Schedule::openMonthlySchedule(1,2024,11);

            $schedules = Schedule::query()
                ->where('user_id', 1)
                ->where('year', 2024)
                ->where('month', 11)
                // ->where('taken', false)
                ->get();


            return view('index',[
                'schedules' => $schedules,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function dashboard()
    {
        try {
            return view('dashboard');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
