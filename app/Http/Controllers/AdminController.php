<?php

namespace App\Http\Controllers;

use App\Models\Bonificacion;
use App\Models\Horario;
use App\Models\Tarifa;
use App\Models\WeeklySchedule;
use App\Support\LandingDefaults;
use App\Support\ThemeSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function edit(): View
    {
        $this->seedDefaultsIfEmpty();

        $weeklySchedules = [];
        for ($day = 0; $day <= 6; $day++) {
            $schedule = WeeklySchedule::where('day_of_week', $day)->first();
            if (!$schedule) {
                $schedule = new WeeklySchedule([
                    'day_of_week' => $day,
                    'is_open' => true,
                    'opening_time' => '08:00',
                    'closing_time' => '20:00',
                    'is_24_hours' => false,
                ]);
            }
            $weeklySchedules[] = $schedule;
        }

        return view('admin', [
            'horarios' => Horario::orderBy('sort_order')->get(),
            'tarifas' => Tarifa::orderBy('sort_order')->get(),
            'bonificaciones' => Bonificacion::orderBy('sort_order')->get(),
            'theme' => ThemeSettings::get(),
            'weeklySchedules' => $weeklySchedules,
        ]);
    }

    public function updateHorarios(Request $request): RedirectResponse
    {
        $payload = $request->input('horarios', []);
        $idsToKeep = [];

        foreach ($payload as $order => $item) {
            $validated = $this->validateHorario($item);
            $model = isset($validated['id']) ? Horario::find($validated['id']) : new Horario();

            $model->fill([
                'name' => $validated['name'],
                'badge_label' => $validated['badge_label'] ?? null,
                'color' => $validated['color'] ?? 'yellow',
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'items' => $this->linesToArray($validated['items'] ?? ''),
                'sort_order' => $order,
            ]);

            $model->save();
            $idsToKeep[] = $model->id;
        }

        Horario::whereNotIn('id', $idsToKeep)->delete();

        return back()->with('status', 'Horarios actualizados');
    }

    public function updateTarifas(Request $request): RedirectResponse
    {
        $payload = $request->input('tarifas', []);
        $idsToKeep = [];

        foreach ($payload as $order => $item) {
            $validated = $this->validateTarifa($item);
            $model = isset($validated['id']) ? Tarifa::find($validated['id']) : new Tarifa();

            $model->fill([
                'vehicle_type' => $validated['vehicle_type'],
                'badge_label' => $validated['badge_label'] ?? null,
                'color' => $validated['color'] ?? 'yellow',
                'per_hour' => $validated['per_hour'] ?? null,
                'twelve_hours' => $validated['twelve_hours'] ?? null,
                'twenty_four_hours' => $validated['twenty_four_hours'] ?? null,
                'sort_order' => $order,
            ]);

            $model->save();
            $idsToKeep[] = $model->id;
        }

        Tarifa::whereNotIn('id', $idsToKeep)->delete();

        return back()->with('status', 'Tarifas actualizadas');
    }

    public function updateBonificaciones(Request $request): RedirectResponse
    {
        $payload = $request->input('bonificaciones', []);
        $idsToKeep = [];

        foreach ($payload as $order => $item) {
            $validated = $this->validateBonificacion($item);
            $model = isset($validated['id']) ? Bonificacion::find($validated['id']) : new Bonificacion();

            // Handle logo upload if provided
            $logoUrl = $model->logo_url;
            if ($request->hasFile("bonificaciones.{$order}.logo")) {
                $path = $request->file("bonificaciones.{$order}.logo")->store('bonificaciones', 'public');
                $logoUrl = '/storage/' . $path;
            }

            $model->fill([
                'name' => $validated['name'],
                'logo_url' => $logoUrl,
                'icon_color' => $validated['icon_color'] ?? 'yellow',
                'icon_svg' => $validated['icon_svg'] ?? null,
                'sort_order' => $order,
            ]);

            $model->save();
            $idsToKeep[] = $model->id;
        }

        Bonificacion::whereNotIn('id', $idsToKeep)->delete();

        return back()->with('status', 'Bonificaciones actualizadas');
    }

    public function updateWeeklySchedules(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'schedules' => ['required', 'array'],
            'schedules.*.day_of_week' => ['required', 'integer', 'between:0,6'],
            'schedules.*.is_open' => ['nullable', 'boolean'],
            'schedules.*.opening_time' => ['nullable', 'date_format:H:i'],
            'schedules.*.closing_time' => ['nullable', 'date_format:H:i'],
            'schedules.*.is_24_hours' => ['nullable', 'boolean'],
            'schedules.*.notes' => ['nullable', 'string', 'max:500'],
        ]);

        foreach ($validated['schedules'] as $scheduleData) {
            WeeklySchedule::updateOrCreate(
                ['day_of_week' => $scheduleData['day_of_week']],
                [
                    'is_open' => $scheduleData['is_open'] ?? false,
                    'opening_time' => ($scheduleData['is_open'] ?? false) && !($scheduleData['is_24_hours'] ?? false) ? $scheduleData['opening_time'] : null,
                    'closing_time' => ($scheduleData['is_open'] ?? false) && !($scheduleData['is_24_hours'] ?? false) ? $scheduleData['closing_time'] : null,
                    'is_24_hours' => $scheduleData['is_24_hours'] ?? false,
                    'notes' => $scheduleData['notes'] ?? null,
                ]
            );
        }

        return back()->with('status', 'Horarios semanales actualizados');
    }

    public function updatePersonalizacion(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'primary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp,svg', 'max:2048'],
            'hero_background' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'],
            'carousel_1' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:4096'],
            'carousel_2' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:4096'],
            'carousel_3' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:4096'],
            'carousel_existing' => ['array'],
            'carousel_existing.*' => ['nullable', 'string'],
            'hero_background_existing' => ['nullable', 'string'],
            'logo_existing' => ['nullable', 'string'],
        ]);

        $theme = ThemeSettings::get();

        // Logo
        if ($request->hasFile('logo')) {
            // Delete old file if it's local
            if (!empty($theme['logo_url']) && str_starts_with($theme['logo_url'], '/storage/')) {
                $oldPath = str_replace('/storage/', '', $theme['logo_url']);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('logo')->store('logos', 'public');
            $theme['logo_url'] = '/storage/' . $path;
        }

        // Hero background
        if ($request->hasFile('hero_background')) {
            // Delete old file if it's local
            if (!empty($theme['hero_background_url']) && str_starts_with($theme['hero_background_url'], '/storage/')) {
                $oldPath = str_replace('/storage/', '', $theme['hero_background_url']);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('hero_background')->store('site', 'public');
            // Usar ruta relativa en lugar de URL absoluta
            $theme['hero_background_url'] = '/storage/' . $path;
        }
        // If no new file is uploaded, keep the existing value from $theme (already loaded from DB/file)

        // Carousel
        $carousel = $validated['carousel_existing'] ?? $theme['carousel_images'] ?? [];
        foreach ([1, 2, 3] as $idx) {
            if ($request->hasFile("carousel_{$idx}")) {
                $path = $request->file("carousel_{$idx}")->store('site', 'public');
                // Usar ruta relativa en lugar de URL absoluta
                $carousel[$idx - 1] = '/storage/' . $path;
            }
        }

        $theme['carousel_images'] = array_values(array_slice($carousel, 0, 3));
        $theme['primary_color'] = $validated['primary_color'];

        ThemeSettings::store($theme);

        return back()->with('status', 'Personalización actualizada');
    }

    public function deleteHeroBackground(): RedirectResponse
    {
        $theme = ThemeSettings::get();

        // Eliminar la imagen del storage si existe y es local
        if (!empty($theme['hero_background_url'])) {
            $path = $theme['hero_background_url'];
            // Solo eliminar si es una ruta local (no una URL externa)
            if (str_starts_with($path, '/storage/')) {
                $filePath = str_replace('/storage/', '', $path);
                Storage::disk('public')->delete($filePath);
            }
        }

        // Eliminar la imagen (null mostrará un fondo degradado sólido)
        $theme['hero_background_url'] = null;

        ThemeSettings::store($theme);

        return back()->with('status', 'Imagen de fondo eliminada. Se mostrará un fondo degradado sólido.');
    }

    public function deleteLogo(): RedirectResponse
    {
        $theme = ThemeSettings::get();

        // Eliminar el logo del storage si existe y es local
        if (!empty($theme['logo_url'])) {
            $path = $theme['logo_url'];
            // Solo eliminar si es una ruta local (no una URL externa)
            if (str_starts_with($path, '/storage/')) {
                $filePath = str_replace('/storage/', '', $path);
                Storage::disk('public')->delete($filePath);
            }
        }

        // Eliminar el logo (null will trigger default SVG in component)
        $theme['logo_url'] = null;

        ThemeSettings::store($theme);

        return back()->with('status', 'Logo eliminado. Se usará el logo por defecto.');
    }

    public function updateContacto(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
        ]);

        $theme = ThemeSettings::get();
        $theme['whatsapp_number'] = $validated['whatsapp_number'];
        $theme['instagram_url'] = $validated['instagram_url'];

        ThemeSettings::store($theme);

        return back()->with('status', 'Información de contacto actualizada');
    }

    private function seedDefaultsIfEmpty(): void
    {
        if (Horario::count() === 0) {
            foreach (LandingDefaults::horarios() as $item) {
                Horario::create($item);
            }
        }

        if (Tarifa::count() === 0) {
            foreach (LandingDefaults::tarifas() as $item) {
                Tarifa::create($item);
            }
        }

        if (Bonificacion::count() === 0) {
            foreach (LandingDefaults::bonificaciones() as $item) {
                Bonificacion::create($item);
            }
        }
    }

    private function linesToArray(string $value): array
    {
        return array_values(
            array_filter(
                array_map('trim', preg_split('/\r\n|\r|\n/', $value)),
                fn ($line) => $line !== ''
            )
        );
    }

    private function validateHorario(array $data): array
    {
        return validator($data, [
            'id' => 'nullable|exists:horarios,id',
            'name' => 'required|string|max:255',
            'badge_label' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:32',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'items' => 'nullable|string',
        ])->validate();
    }

    private function validateTarifa(array $data): array
    {
        return validator($data, [
            'id' => 'nullable|exists:tarifas,id',
            'vehicle_type' => 'required|string|max:255',
            'badge_label' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:32',
            'per_hour' => 'nullable|string|max:255',
            'twelve_hours' => 'nullable|string|max:255',
            'twenty_four_hours' => 'nullable|string|max:255',
        ])->validate();
    }

    private function validateBonificacion(array $data): array
    {
        return validator($data, [
            'id' => 'nullable|exists:bonificaciones,id',
            'name' => 'required|string|max:255',
            'icon_color' => 'nullable|string|max:32',
            'icon_svg' => 'nullable|string',
        ])->validate();
    }
}
