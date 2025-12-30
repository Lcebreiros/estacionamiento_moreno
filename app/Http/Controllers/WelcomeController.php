<?php

namespace App\Http\Controllers;

use App\Models\Bonificacion;
use App\Models\Horario;
use App\Models\Tarifa;
use App\Models\WeeklySchedule;
use App\Support\LandingDefaults;
use App\Support\ThemeSettings;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        $horarios = Horario::orderBy('sort_order')
            ->get()
            ->map(function (Horario $horario) {
                $horario->items = $horario->items ?? [];

                return $horario;
            });

        $tarifas = Tarifa::orderBy('sort_order')->get();

        $horarios = $horarios->isEmpty()
            ? collect(LandingDefaults::horarios())->map(fn ($item) => (object) $item)
            : $horarios;

        $tarifas = $tarifas->isEmpty()
            ? collect(LandingDefaults::tarifas())->map(fn ($item) => (object) $item)
            : $tarifas;

        $bonificaciones = Bonificacion::orderBy('sort_order')->get();

        $bonificaciones = $bonificaciones->isEmpty()
            ? collect(LandingDefaults::bonificaciones())->map(fn ($item) => (object) $item)
            : $bonificaciones;

        $weeklySchedules = WeeklySchedule::orderBy('day_of_week')->get();

        return view('welcome', [
            'horarios' => $horarios,
            'tarifas' => $tarifas,
            'bonificaciones' => $bonificaciones,
            'weeklySchedules' => $weeklySchedules,
            'theme' => ThemeSettings::get(),
        ]);
    }
}
