<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Panel de Administración</h1>
            <p class="text-sm text-gray-500 mt-1">Estacionamiento Moreno</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-800 border border-green-200 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            @php($colors = ['yellow' => 'Amarillo', 'green' => 'Verde', 'blue' => 'Azul'])

            <div class="space-y-6">
                <!-- TAB: Personalización Visual (placeholder) -->
                <section id="tab-personalizacion" class="tab-content bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Personalización Visual</h2>
                        <p class="text-sm text-gray-500 mt-1">Personaliza colores, imágenes y estilo del sitio web</p>
                    </div>

                    <form method="POST" action="{{ route('admin.personalizacion.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="space-y-3 p-5 bg-slate-50 rounded-xl border-2 border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700">Logo del sitio</label>
                            <input type="file" name="logo" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,image/svg+xml"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-500 transition">
                            <input type="hidden" name="logo_existing" value="{{ $theme['logo_url'] ?? '' }}">

                            @if(!empty($theme['logo_url']))
                                <div class="flex items-center gap-4 p-4 bg-white rounded-lg border-2 border-gray-200">
                                    <img src="{{ $theme['logo_url'] }}" alt="Logo actual" class="h-16 w-auto object-contain">
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-700">Logo actual</p>
                                        <p class="text-xs text-gray-500">Este logo aparece en la barra de navegación</p>
                                    </div>
                                    <button type="button"
                                            onclick="if(confirm('¿Estás seguro de eliminar el logo personalizado?')) { document.getElementById('delete-logo-form').submit(); }"
                                            class="px-4 py-2 bg-red-50 text-red-600 border-2 border-red-200 font-semibold rounded-lg hover:bg-red-100 hover:border-red-300 transition">
                                        Eliminar
                                    </button>
                                </div>
                            @else
                                <div class="flex items-center gap-4 p-4 bg-white rounded-lg border-2 border-dashed border-gray-300">
                                    <div class="h-16 w-16 flex items-center justify-center bg-gray-100 rounded-lg">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-700">Sin logo personalizado</p>
                                        <p class="text-xs text-gray-500">Se mostrará el logo por defecto (SVG)</p>
                                    </div>
                                </div>
                            @endif
                            <p class="text-xs text-gray-500">Formatos: JPG, PNG, GIF, WebP, SVG. Recomendado: fondo transparente, máx 2MB.</p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-700">Color de tema</label>
                                <div class="flex gap-3 items-center">
                                    <input type="color" id="primary_color_picker" value="{{ $theme['primary_color'] ?? '#eab308' }}"
                                           class="h-12 w-20 rounded-xl cursor-pointer border-2 border-gray-200"
                                           oninput="document.getElementById('primary_color_input').value = this.value">
                                    <input type="text" id="primary_color_input" name="primary_color" value="{{ $theme['primary_color'] ?? '#eab308' }}"
                                           class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 font-mono text-sm"
                                           placeholder="#eab308"
                                           oninput="document.getElementById('primary_color_picker').value = this.value">
                                </div>
                                <p class="text-xs text-gray-500">Se aplica a botones y acentos del sitio.</p>
                            </div>

                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-700">Imagen de fondo (Hero)</label>
                                <input type="file" name="hero_background" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-500 transition">
                                <input type="hidden" name="hero_background_existing" value="{{ $theme['hero_background_url'] ?? '' }}">

                                @if(!empty($theme['hero_background_url']))
                                    {{-- Preview de la imagen --}}
                                    <div class="relative group mb-4">
                                        <div class="w-full rounded-xl border-2 border-gray-200 bg-gray-100 bg-no-repeat bg-center shadow-lg"
                                             style="height: 200px; background-image: url('{{ $theme['hero_background_url'] }}'); background-size: contain; background-position: center;">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center">
                                                <p class="text-white text-sm font-semibold">Vista previa de la imagen actual</p>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button"
                                            onclick="if(confirm('¿Estás seguro de eliminar esta imagen? El fondo será un degradado sólido.')) { document.getElementById('delete-hero-form').submit(); }"
                                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-red-50 text-red-600 border-2 border-red-200 font-semibold rounded-xl hover:bg-red-100 hover:border-red-300 transition cursor-pointer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Eliminar imagen de fondo
                                    </button>
                                @else
                                    {{-- Placeholder cuando no hay imagen --}}
                                    <div class="w-full h-64 rounded-xl border-2 border-dashed border-gray-300 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex items-center justify-center">
                                        <div class="text-center text-gray-300">
                                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <p class="text-sm font-semibold">Sin imagen de fondo</p>
                                            <p class="text-xs">Se mostrará un fondo degradado sólido</p>
                                        </div>
                                    </div>
                                @endif

                                <p class="text-xs text-gray-500">Formatos: JPG, PNG, GIF, WebP. Recomendado 1920x1080px, máx 5MB. Opcional.</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-700">Imágenes del carrusel "Conócenos"</label>
                            <div class="grid md:grid-cols-3 gap-4">
                                @foreach ($theme['carousel_images'] as $idx => $img)
                                    <div class="space-y-2">
                                        <input type="file" name="carousel_{{ $idx + 1 }}" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                               class="w-full px-3 py-2 rounded-xl border-2 border-gray-200 text-sm focus:border-yellow-500 transition">
                                        <input type="hidden" name="carousel_existing[{{ $idx }}]" value="{{ $img ?? '' }}">
                                        @if(!empty($img))
                                            <div class="h-32 rounded-lg border-2 border-gray-200 bg-gray-50 bg-cover bg-center"
                                                 style="background-image: url('{{ $img }}')"></div>
                                        @else
                                            <div class="h-32 rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center">
                                                <span class="text-xs text-gray-400">Sin imagen</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500">Formatos: JPG, PNG, GIF, WebP. Máximo 4MB por imagen.</p>
                        </div>

                        <div class="pt-4 border-t border-gray-200 flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition shadow-lg shadow-yellow-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Guardar personalización
                            </button>
                        </div>
                    </form>
                </section>

                <!-- TAB: Información de Contacto -->
                <section id="tab-contacto" class="tab-content hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Información de Contacto</h2>
                        <p class="text-sm text-gray-500 mt-1">Configura los datos de contacto que se mostrarán en el sitio web</p>
                    </div>

                    <form method="POST" action="{{ route('admin.contacto.update') }}" class="space-y-6">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-3 p-5 bg-green-50 rounded-xl border-2 border-green-200">
                                <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                    Número de WhatsApp
                                </label>
                                <input type="text" name="whatsapp_number" value="{{ $theme['whatsapp_number'] ?? '' }}"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-green-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition"
                                       placeholder="541123456789">
                                <p class="text-xs text-gray-600">
                                    <strong>Formato:</strong> Código de país + código de área + número (sin espacios ni guiones)<br>
                                    <strong>Ejemplo Argentina:</strong> 541123456789 (54 + 11 + número)
                                </p>
                                <div class="mt-3 p-3 bg-white rounded-lg border border-green-300">
                                    <p class="text-xs font-semibold text-gray-700 mb-1">Este número se usará en:</p>
                                    <ul class="text-xs text-gray-600 space-y-1 ml-4">
                                        <li>• Botón flotante de WhatsApp</li>
                                        <li>• Enlaces del footer</li>
                                        <li>• Sección de contacto</li>
                                        <li>• Botón "Contactar" del header</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="space-y-3 p-5 bg-purple-50 rounded-xl border-2 border-purple-200">
                                <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                    URL de Instagram
                                </label>
                                <input type="url" name="instagram_url" value="{{ $theme['instagram_url'] ?? '' }}"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-purple-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                                       placeholder="https://instagram.com/tu_cuenta">
                                <p class="text-xs text-gray-600">
                                    <strong>Formato:</strong> URL completa de tu perfil de Instagram<br>
                                    <strong>Ejemplo:</strong> https://instagram.com/estacionamientomoreno
                                </p>
                                <div class="mt-3 p-3 bg-white rounded-lg border border-purple-300">
                                    <p class="text-xs font-semibold text-gray-700 mb-1">Este enlace se usará en:</p>
                                    <ul class="text-xs text-gray-600 space-y-1 ml-4">
                                        <li>• Ícono de Instagram en el footer</li>
                                        <li>• Redes sociales del sitio</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Actualización en tiempo real</p>
                                <p>Los cambios se aplicarán inmediatamente en todos los botones y enlaces del sitio web al guardar.</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-200 flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition shadow-lg shadow-yellow-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Guardar información de contacto
                            </button>
                        </div>
                    </form>
                </section>

                <!-- TAB: Horarios Semanales -->
                <section id="tab-horarios-semana" class="tab-content hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Horarios Semanales</h2>
                        <p class="text-sm text-gray-500 mt-1">Define los horarios de apertura y cierre para cada día de la semana</p>
                    </div>

                    <form method="POST" action="{{ route('admin.weekly-schedules.update') }}">
                        @csrf
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b-2 border-gray-200">
                                        <th class="text-left p-4 font-semibold text-gray-700">Día</th>
                                        <th class="text-center p-4 font-semibold text-gray-700 w-24">Abierto</th>
                                        <th class="text-center p-4 font-semibold text-gray-700 w-32">Horario de apertura</th>
                                        <th class="text-center p-4 font-semibold text-gray-700 w-32">Horario de cierre</th>
                                        <th class="text-center p-4 font-semibold text-gray-700 w-28">24 horas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($weeklySchedules as $schedule)
                                        <tr class="border-b border-gray-100 hover:bg-slate-50 transition">
                                            <td class="p-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white font-bold text-sm">
                                                        {{ substr(\App\Models\WeeklySchedule::getDayNames()[$schedule->day_of_week], 0, 2) }}
                                                    </div>
                                                    <span class="font-semibold text-gray-900">{{ \App\Models\WeeklySchedule::getDayNames()[$schedule->day_of_week] }}</span>
                                                </div>
                                                <input type="hidden" name="schedules[{{ $schedule->day_of_week }}][day_of_week]" value="{{ $schedule->day_of_week }}">
                                            </td>
                                            <td class="p-4 text-center">
                                                <input type="checkbox"
                                                       name="schedules[{{ $schedule->day_of_week }}][is_open]"
                                                       value="1"
                                                       {{ $schedule->is_open ? 'checked' : '' }}
                                                       class="w-5 h-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-500 cursor-pointer"
                                                       onchange="toggleDayInputs({{ $schedule->day_of_week }}, this.checked)">
                                            </td>
                                            <td class="p-4 text-center">
                                                <input type="time"
                                                       name="schedules[{{ $schedule->day_of_week }}][opening_time]"
                                                       value="{{ $schedule->opening_time ? substr($schedule->opening_time, 0, 5) : '08:00' }}"
                                                       class="day-{{ $schedule->day_of_week }}-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500"
                                                       {{ !$schedule->is_open || $schedule->is_24_hours ? 'disabled' : '' }}>
                                            </td>
                                            <td class="p-4 text-center">
                                                <input type="time"
                                                       name="schedules[{{ $schedule->day_of_week }}][closing_time]"
                                                       value="{{ $schedule->closing_time ? substr($schedule->closing_time, 0, 5) : '20:00' }}"
                                                       class="day-{{ $schedule->day_of_week }}-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500"
                                                       {{ !$schedule->is_open || $schedule->is_24_hours ? 'disabled' : '' }}>
                                            </td>
                                            <td class="p-4 text-center">
                                                <input type="checkbox"
                                                       name="schedules[{{ $schedule->day_of_week }}][is_24_hours]"
                                                       value="1"
                                                       {{ $schedule->is_24_hours ? 'checked' : '' }}
                                                       class="w-5 h-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-500 cursor-pointer"
                                                       {{ !$schedule->is_open ? 'disabled' : '' }}
                                                       onchange="toggle24Hours({{ $schedule->day_of_week }}, this.checked)">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Horarios de corrido</p>
                                <p>Si el horario de cierre es menor que el de apertura (ej: abre 20:00 y cierra 05:00), el sistema entiende que cierra al día siguiente.</p>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-200 mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition shadow-lg shadow-yellow-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Guardar horarios semanales
                            </button>
                        </div>
                    </form>
                </section>

                <!-- TAB: Tarifas -->
                <section id="tab-tarifas" class="tab-content hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Tarifas</h2>
                        <p class="text-sm text-gray-500 mt-1">Configura los precios por tipo de vehículo</p>
                    </div>

                    <form method="POST" action="{{ route('admin.tarifas.update') }}" class="space-y-4">
                        @csrf

                        <div class="flex items-center justify-between">
                            <button type="button" onclick="addTarifa()"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition shadow-lg shadow-yellow-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Agregar tarifa
                            </button>
                        </div>
                        <div id="tarifas-list" class="space-y-4">
                            @foreach ($tarifas as $index => $tarifa)
                                <div class="tarifa-card bg-slate-50 rounded-2xl p-5 border-2 border-gray-200 hover:border-yellow-500/30 transition">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-bold text-gray-900">Tarifa {{ $index + 1 }}</h3>
                                        <button type="button" onclick="this.closest('.tarifa-card').remove()"
                                                class="px-3 py-1.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition text-sm font-semibold">
                                            Eliminar
                                        </button>
                                    </div>
                                    <input type="hidden" name="tarifas[{{ $index }}][id]" value="{{ $tarifa->id }}">

                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipo de vehículo</label>
                                            <input name="tarifas[{{ $index }}][vehicle_type]" value="{{ $tarifa->vehicle_type }}"
                                                   class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm" required>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Etiqueta</label>
                                                <input name="tarifas[{{ $index }}][badge_label]" value="{{ $tarifa->badge_label }}"
                                                       class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Color</label>
                                                <select name="tarifas[{{ $index }}][color]"
                                                        class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm">
                                                    <option value="yellow" @selected($tarifa->color === 'yellow')>Amarillo</option>
                                                    <option value="green" @selected($tarifa->color === 'green')>Verde</option>
                                                    <option value="blue" @selected($tarifa->color === 'blue')>Azul</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid md:grid-cols-3 gap-3 mt-3">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Por hora</label>
                                            <input name="tarifas[{{ $index }}][per_hour]" value="{{ $tarifa->per_hour }}"
                                                   class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm"
                                                   placeholder="$1000">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Estadía 12 hs</label>
                                            <input name="tarifas[{{ $index }}][twelve_hours]" value="{{ $tarifa->twelve_hours }}"
                                                   class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm"
                                                   placeholder="$8000">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Estadía 24 hs</label>
                                            <input name="tarifas[{{ $index }}][twenty_four_hours]" value="{{ $tarifa->twenty_four_hours }}"
                                                   class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm"
                                                   placeholder="$12000">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <button type="submit"
                                    class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition shadow-lg shadow-yellow-500/30">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Guardar tarifas
                            </button>
                        </div>
                    </form>
                </section>

                <!-- TAB: Bonificaciones -->
                <section id="tab-bonificaciones" class="tab-content hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Bonificaciones</h2>
                        <p class="text-sm text-gray-500 mt-1">Gestiona los comercios aliados con beneficios de estacionamiento</p>
                    </div>

                    <form method="POST" action="{{ route('admin.bonificaciones.update') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div class="flex items-center justify-between">
                            <button type="button" onclick="addBonificacion()"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition shadow-lg shadow-yellow-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Agregar comercio aliado
                            </button>
                        </div>

                        <div id="bonificaciones-list" class="space-y-4">
                            @foreach ($bonificaciones as $index => $bonificacion)
                                <div class="bonificacion-card bg-slate-50 rounded-2xl p-5 border-2 border-gray-200 hover:border-yellow-500/30 transition">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-bold text-gray-900">Comercio {{ $index + 1 }}</h3>
                                        <button type="button" onclick="this.closest('.bonificacion-card').remove()"
                                                class="px-3 py-1.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition text-sm font-semibold">
                                            Eliminar
                                        </button>
                                    </div>
                                    <input type="hidden" name="bonificaciones[{{ $index }}][id]" value="{{ $bonificacion->id }}">

                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nombre del comercio</label>
                                            <input name="bonificaciones[{{ $index }}][name]" value="{{ $bonificacion->name }}"
                                                   class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm" required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Color del ícono</label>
                                            <select name="bonificaciones[{{ $index }}][icon_color]"
                                                    class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm">
                                                <option value="red" @selected($bonificacion->icon_color === 'red')>Rojo</option>
                                                <option value="yellow" @selected($bonificacion->icon_color === 'yellow')>Amarillo</option>
                                                <option value="blue" @selected($bonificacion->icon_color === 'blue')>Azul</option>
                                                <option value="emerald" @selected($bonificacion->icon_color === 'emerald')>Verde</option>
                                                <option value="purple" @selected($bonificacion->icon_color === 'purple')>Morado</option>
                                                <option value="orange" @selected($bonificacion->icon_color === 'orange')>Naranja</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Logo personalizado (opcional)</label>
                                        <input type="file" name="bonificaciones[{{ $index }}][logo]" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-yellow-500 transition text-sm">
                                        @if($bonificacion->logo_url)
                                            <div class="mt-2 flex items-center gap-2">
                                                <img src="{{ $bonificacion->logo_url }}" alt="Logo" class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                                                <span class="text-xs text-gray-500">Logo actual</span>
                                            </div>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-1">Si no subes logo, se usará un ícono genérico con el color seleccionado</p>
                                    </div>

                                    <div class="mt-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Ícono SVG (opcional, avanzado)</label>
                                        <textarea name="bonificaciones[{{ $index }}][icon_svg]" rows="2"
                                                  class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition font-mono text-xs">{{ $bonificacion->icon_svg }}</textarea>
                                        <p class="text-xs text-gray-500">Solo el contenido &lt;path&gt; del SVG. Ej: &lt;path d="M12 2L2 7..."&gt;</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <button type="submit"
                                    class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition shadow-lg shadow-yellow-500/30">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Guardar bonificaciones
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>

    <!-- Templates para agregar dinámicamente -->
    <script type="text/template" id="tarifa-template">
        <div class="tarifa-card bg-slate-50 rounded-2xl p-5 border-2 border-gray-200 hover:border-yellow-500/30 transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Nueva Tarifa</h3>
                <button type="button" onclick="this.closest('.tarifa-card').remove()"
                        class="px-3 py-1.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition text-sm font-semibold">
                    Eliminar
                </button>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipo de vehículo</label>
                    <input name="tarifas[__INDEX__][vehicle_type]"
                           class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm" required>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Etiqueta</label>
                        <input name="tarifas[__INDEX__][badge_label]"
                               class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Color</label>
                        <select name="tarifas[__INDEX__][color]"
                                class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm">
                            <option value="yellow">Amarillo</option>
                            <option value="green">Verde</option>
                            <option value="blue">Azul</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-3 mt-3">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Por hora</label>
                    <input name="tarifas[__INDEX__][per_hour]"
                           class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm"
                           placeholder="$1000">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Estadía 12 hs</label>
                    <input name="tarifas[__INDEX__][twelve_hours]"
                           class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm"
                           placeholder="$8000">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Estadía 24 hs</label>
                    <input name="tarifas[__INDEX__][twenty_four_hours]"
                           class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm"
                           placeholder="$12000">
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id="bonificacion-template">
        <div class="bonificacion-card bg-slate-50 rounded-2xl p-5 border-2 border-gray-200 hover:border-yellow-500/30 transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Nuevo Comercio</h3>
                <button type="button" onclick="this.closest('.bonificacion-card').remove()"
                        class="px-3 py-1.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition text-sm font-semibold">
                    Eliminar
                </button>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nombre del comercio</label>
                    <input name="bonificaciones[__INDEX__][name]"
                           class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Color del ícono</label>
                    <select name="bonificaciones[__INDEX__][icon_color]"
                            class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm">
                        <option value="red">Rojo</option>
                        <option value="yellow">Amarillo</option>
                        <option value="blue">Azul</option>
                        <option value="emerald">Verde</option>
                        <option value="purple">Morado</option>
                        <option value="orange">Naranja</option>
                    </select>
                </div>
            </div>

            <div class="mt-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Logo personalizado (opcional)</label>
                <input type="file" name="bonificaciones[__INDEX__][logo]" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                       class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-yellow-500 transition text-sm">
                <p class="text-xs text-gray-500 mt-1">Si no subes logo, se usará un ícono genérico con el color seleccionado</p>
            </div>

            <div class="mt-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Ícono SVG (opcional, avanzado)</label>
                <textarea name="bonificaciones[__INDEX__][icon_svg]" rows="2"
                          class="w-full bg-white rounded-lg px-3 py-2 border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition font-mono text-xs"></textarea>
                <p class="text-xs text-gray-500">Solo el contenido &lt;path&gt; del SVG. Ej: &lt;path d="M12 2L2 7..."&gt;</p>
            </div>
        </div>
    </script>

    <style>
        .tab-content {
            animation: fadeIn 0.4s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
        function addTarifa() {
            const list = document.getElementById('tarifas-list');
            const template = document.getElementById('tarifa-template').innerHTML;
            const index = list.children.length;
            list.insertAdjacentHTML('beforeend', template.replaceAll('__INDEX__', index));
        }

        function addBonificacion() {
            const list = document.getElementById('bonificaciones-list');
            const template = document.getElementById('bonificacion-template')?.innerHTML;
            if (!template || !list) return;
            const index = list.children.length;
            list.insertAdjacentHTML('beforeend', template.replaceAll('__INDEX__', index));
        }

        // Weekly schedules functions
        function toggleDayInputs(dayOfWeek, isOpen) {
            const inputs = document.querySelectorAll(`.day-${dayOfWeek}-input`);
            const checkbox24h = document.querySelector(`input[name="schedules[${dayOfWeek}][is_24_hours]"]`);

            inputs.forEach(input => {
                input.disabled = !isOpen || checkbox24h?.checked;
            });

            if (checkbox24h) {
                checkbox24h.disabled = !isOpen;
                if (!isOpen) {
                    checkbox24h.checked = false;
                }
            }
        }

        function toggle24Hours(dayOfWeek, is24Hours) {
            const inputs = document.querySelectorAll(`.day-${dayOfWeek}-input`);
            inputs.forEach(input => {
                input.disabled = is24Hours;
            });
        }

        // Hash-based navigation for switching between admin sections
        function showTabFromHash() {
            const hash = window.location.hash.substring(1);
            const tabName = hash || 'personalizacion';

            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Show the selected tab
            const targetTab = document.getElementById('tab-' + tabName);
            if (targetTab) {
                targetTab.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', showTabFromHash);
        window.addEventListener('hashchange', showTabFromHash);
    </script>

    <!-- Form oculto para eliminar imagen de fondo -->
    <form id="delete-hero-form" method="POST" action="{{ route('admin.personalizacion.delete-hero') }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Form oculto para eliminar logo -->
    <form id="delete-logo-form" method="POST" action="{{ route('admin.personalizacion.delete-logo') }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>
