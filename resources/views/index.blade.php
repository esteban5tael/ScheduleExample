@extends('layouts.base')

@section('title')
    {{ config('app.name') }} - Calendario de Citas
@endsection

@section('content')
<div class="container mt-4">
    <h3 class="text-center mb-4">{{ config('app.name') }} - Calendario de Citas</h3>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Domingo</th>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sábado</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $currentDay = 1;
                    $lastDayOfMonth = now()->year(2024)->month(11)->endOfMonth()->day;
                    $dayOfWeek = now()->year(2024)->month(11)->day(1)->dayOfWeek;
                @endphp

                {{-- Fila inicial para llenar los primeros días vacíos antes del primer día del mes --}}
                <tr>
                    @for ($i = 0; $i < $dayOfWeek; $i++)
                        <td></td>
                    @endfor

                    {{-- Mostrar días del mes y citas --}}
                    @while ($currentDay <= $lastDayOfMonth)
                        {{-- Verificar si el día de la semana es domingo y abrir una nueva fila --}}
                        @if ($dayOfWeek == 0 && $currentDay != 1)
                            </tr><tr>
                        @endif

                        {{-- Mostrar el día del mes con sus citas --}}
                        <td>
                            <div class="fw-bold">{{ $currentDay }}</div>

                            {{-- Filtrar las citas del día actual --}}
                            @php
                                $dailySchedules = $schedules->filter(function ($schedule) use ($currentDay) {
                                    return $schedule->day == $currentDay;
                                });
                            @endphp

                            @forelse ($dailySchedules as $schedule)
                                <div class="mt-1 {{ $schedule->taken ? 'bg-danger text-white' : 'bg-success text-white' }} p-2 rounded">
                                    {{ $schedule->start }} - {{ $schedule->end }}
                                    <span>{{ $schedule->taken ? 'Ocupada' : 'Disponible' }}</span>
                                </div>
                            @empty
                                <small class="text-muted">Sin citas</small>
                            @endforelse
                        </td>

                        {{-- Avanzar al siguiente día --}}
                        @php
                            $currentDay++;
                            $dayOfWeek = ($dayOfWeek + 1) % 7;
                        @endphp
                    @endwhile

                    {{-- Rellenar los días vacíos después del último día del mes --}}
                    @for ($i = $dayOfWeek; $i < 7 && $dayOfWeek != 0; $i++)
                        <td></td>
                    @endfor
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
