<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'year',
        'month',
        'day',
        'dayofweek',
        'off',
        'start',
        'end',
        'description',
        'taken',
    ];

    protected $casts = [
        'off' => 'boolean',
        'taken' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function openMonthlySchedule(int $userId, int $year, int $month)
    {

        // Verificar si ya existe una agenda para el usuario en el mes y año especificado
        $exists = Schedule::where('user_id', $userId)
                          ->where('year', $year)
                          ->where('month', $month)
                          ->exists();

        if ($exists) {
            // Si ya hay agenda, salir del método para evitar duplicados
            return;
        }

        $startHour = 8; // 8 a.m.
        $endHour = 17; // 5 p.m.
        $appointmentDuration = 50; // minutos
        $restDuration = 10; // minutos

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $schedules = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dayOfWeek = $date->dayOfWeek;

            if (/* $dayOfWeek === Carbon::SATURDAY || */ $dayOfWeek === Carbon::SUNDAY) {
                continue;
            }

            $currentStart = $date->copy()->setTime($startHour, 0);
            $currentEnd = $currentStart->copy()->addMinutes($appointmentDuration);

            while ($currentEnd->hour < $endHour || ($currentEnd->hour === $endHour && $currentEnd->minute === 0)) {
                $schedules[] = [
                    'user_id' => $userId,
                    'year' => $year,
                    'month' => $month,
                    'day' => $date->day,
                    'dayofweek' => $dayOfWeek,
                    'off' => false,
                    'start' => $currentStart->format('H:i:s'),
                    'end' => $currentEnd->format('H:i:s'),
                    'description' => null,
                    'taken' => false,
                ];

                $currentStart = $currentEnd->copy()->addMinutes($restDuration);
                $currentEnd = $currentStart->copy()->addMinutes($appointmentDuration);
            }
        }

        // Inserta usando el modelo Schedule
        Schedule::insert($schedules);
    }
}
