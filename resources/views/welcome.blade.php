<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estacionamiento Moreno | Seguro, rápido y con beneficios</title>
    <meta name="description" content="Estacionamiento techado. Tarifas claras, monitoreo 24/7, bonificaciones con restaurantes vecinos y atención personalizada.">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --primary: {{ $theme['primary_color'] ?? '#eab308' }};
            --primary-strong: color-mix(in srgb, var(--primary) 85%, #000 15%);
            --primary-soft: color-mix(in srgb, var(--primary) 20%, #fff 80%);
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }
        body {
            @if(!empty($theme['hero_background_url']))
            background-image: url('{{ $theme['hero_background_url'] }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            @else
            background-color: #0f172a;
            @endif
            position: relative;
        }

        /* Hero con background fijo */
        .hero-section {
            position: relative;
        }
        
        /* Carrusel para sección Conocenos */
        .carousel-container {
            position: relative;
            overflow: hidden;
            border-radius: 1.5rem;
        }
        
        .carousel-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1.2s ease-in-out;
        }
        
        .carousel-slide.active {
            opacity: 1;
        }
        
        /* Animaciones suaves */
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Efecto glassmorphism - versión mejorada */
        .glass {
            background: rgba(15, 23, 42, 0.70);
            backdrop-filter: blur(10px) saturate(150%);
            -webkit-backdrop-filter: blur(10px) saturate(150%);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }
        
        /* Hover suave en cards */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(251, 191, 36, 0.2);
        }

        /* Mejoras de accesibilidad */
        *:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-strong) 100%);
            color: #0f172a;
        }
        .btn-primary:hover {
            filter: brightness(1.05);
        }
        .text-primary { color: var(--primary); }
        .badge-primary {
            background: color-mix(in srgb, var(--primary) 18%, transparent);
            color: var(--primary);
        }
        .border-primary {
            border-color: color-mix(in srgb, var(--primary) 70%, transparent);
        }

        /* Overlay general solo cuando hay imagen de fondo */
        @if(!empty($theme['hero_background_url']))
        .page-overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.92) 0%, rgba(15, 23, 42, 0.88) 50%, rgba(15, 23, 42, 0.92) 100%);
            pointer-events: none;
            z-index: 0;
        }
        .page-content {
            position: relative;
            z-index: 1;
        }
        @endif

        .section-overlay {
            position: absolute;
            inset: 0;
            z-index: -1;
        }

        /* Glass effect más definido cuando hay background image */
        @if(!empty($theme['hero_background_url']))
        .glass {
            background: rgba(15, 23, 42, 0.90);
            backdrop-filter: blur(16px) saturate(150%);
            -webkit-backdrop-filter: blur(16px) saturate(150%);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        @endif
    </style>
</head>
<body class="bg-slate-900/90 text-white antialiased">
    @if(!empty($theme['hero_background_url']))
    <div class="page-overlay"></div>
    @endif
    <div class="{{ !empty($theme['hero_background_url']) ? 'page-content' : '' }}">

    <!-- Header -->
    <header class="fixed top-0 w-full z-50 glass shadow-lg shadow-black/10">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <img src="{{ asset('images/logo-estacionamiento.png') }}" alt="Estacionamiento Moreno" class="max-w-full max-h-full object-contain"
                 style="width: 7.9rem; height: 4.4rem; max-width: 7.9rem; max-height: 4.4rem; display: block; margin: 0;">

            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="#inicio" class="text-slate-200 hover:text-yellow-400 transition">Inicio</a>
                <a href="#conocenos" class="text-slate-200 hover:text-yellow-400 transition">Conócenos</a>
                <a href="#horarios" class="text-slate-200 hover:text-yellow-400 transition">Horarios</a>
                <a href="#tarifas" class="text-slate-200 hover:text-yellow-400 transition">Tarifas</a>
                <a href="#ubicacion" class="text-slate-200 hover:text-yellow-400 transition">Ubicación</a>
                <a href="#contacto" class="inline-flex items-center gap-2 bg-yellow-500 text-slate-900 font-semibold px-5 py-2.5 rounded-lg hover:bg-yellow-400 transition shadow-lg shadow-yellow-500/30">
                    Contactar
                </a>
            </nav>

            <button id="menu-toggle" class="md:hidden p-2 rounded-lg glass text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden glass border-t border-white/10">
            <div class="px-6 py-4 space-y-3">
                <a href="#inicio" class="block py-2 text-slate-200 hover:text-yellow-400">Inicio</a>
                <a href="#conocenos" class="block py-2 text-slate-200 hover:text-yellow-400">Conócenos</a>
                <a href="#horarios" class="block py-2 text-slate-200 hover:text-yellow-400">Horarios</a>
                <a href="#tarifas" class="block py-2 text-slate-200 hover:text-yellow-400">Tarifas</a>
                <a href="#ubicacion" class="block py-2 text-slate-200 hover:text-yellow-400">Ubicación</a>
                <a href="#contacto" class="block w-full text-center bg-yellow-500 text-slate-900 font-semibold px-5 py-2.5 rounded-lg">
                    Contactar
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="inicio" class="hero-section min-h-screen flex items-center pt-20 relative">
        @if(empty($theme['hero_background_url']))
        <div class="section-overlay bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
        @endif
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 py-20">
            <div class="max-w-3xl fade-in">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass mb-6">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-sm font-medium text-green-300">Abierto 24/7 · Seguridad garantizada</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                    Estacioná <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-yellow-600">seguro</span> en el centro de Moreno
                </h1>
                
                <p class="text-xl text-slate-300 mb-8 leading-relaxed">
                    Acceso rápido, vigilancia permanente y beneficios exclusivos en restaurantes de la zona. Tu auto protegido mientras disfrutás del centro.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#tarifas" class="inline-flex items-center justify-center gap-2 btn-primary font-bold px-8 py-4 rounded-xl transition shadow-xl shadow-yellow-500/30 group">
                        Ver tarifas
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="#conocenos" class="inline-flex items-center justify-center gap-2 glass text-white font-semibold px-8 py-4 rounded-xl hover:bg-white/10 transition">
                        Conocer más
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 mt-16 pt-8 border-t border-white/10">
                    <div>
                        <p class="text-3xl font-bold text-primary">150+</p>
                        <p class="text-sm text-slate-400 mt-1">Lugares cubiertos</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-primary">24/7</p>
                        <p class="text-sm text-slate-400 mt-1">Vigilancia activa</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-primary">98%</p>
                        <p class="text-sm text-slate-400 mt-1">Clientes satisfechos</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Horarios de Atención -->
    <section id="horarios" class="py-20 relative overflow-hidden">
        @if(empty($theme['hero_background_url']))
        <div class="section-overlay bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
        @endif
        <!-- Decorative gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 via-transparent to-green-500/5 pointer-events-none z-0"></div>

        <div class="max-w-7xl mx-auto px-6 relative">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass border border-yellow-500/20 mb-4">
                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-yellow-400 font-semibold text-xs uppercase tracking-wider">Horarios de Atención</span>
                </div>
                <h2 class="text-3xl md:text-5xl font-bold bg-gradient-to-r from-white via-slate-100 to-white bg-clip-text text-transparent mb-3">¿Cuándo estamos abiertos?</h2>
                <p class="text-slate-300 text-lg">Consultá nuestros horarios para cada día de la semana</p>
            </div>

            @php
                // Reorder to start with Monday (1) instead of Sunday (0)
                $orderedSchedules = $weeklySchedules->sortBy(function ($schedule) {
                    return $schedule->day_of_week == 0 ? 7 : $schedule->day_of_week;
                })->values();

                $today = now()->dayOfWeek;
                $todayAdjusted = $today == 0 ? 7 : $today;
            @endphp

            <!-- Grid de tarjetas de días -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-4">
                @foreach ($orderedSchedules as $schedule)
                    @php
                        $scheduleDay = $schedule->day_of_week == 0 ? 7 : $schedule->day_of_week;
                        $isToday = $scheduleDay === $todayAdjusted;

                        // Nombres de días abreviados
                        $dayNames = [
                            1 => ['full' => 'Lunes', 'short' => 'Lun'],
                            2 => ['full' => 'Martes', 'short' => 'Mar'],
                            3 => ['full' => 'Miércoles', 'short' => 'Mié'],
                            4 => ['full' => 'Jueves', 'short' => 'Jue'],
                            5 => ['full' => 'Viernes', 'short' => 'Vie'],
                            6 => ['full' => 'Sábado', 'short' => 'Sáb'],
                            7 => ['full' => 'Domingo', 'short' => 'Dom'],
                        ];
                        $dayName = $dayNames[$scheduleDay];
                    @endphp

                    <div class="glass rounded-2xl border-2 {{ $isToday ? 'border-yellow-500/50 shadow-lg shadow-yellow-500/10 bg-slate-900/70' : 'border-white/10 bg-slate-900/60' }} backdrop-blur-xl transition-all duration-300 hover:scale-105 hover:border-yellow-500/30 hover:shadow-xl group">
                        <!-- Header de la tarjeta -->
                        <div class="p-4 border-b border-white/10 {{ $isToday ? 'bg-gradient-to-br from-yellow-500/10 to-yellow-600/5' : '' }}">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-bold text-white text-lg lg:text-base">{{ $dayName['short'] }}</h3>
                                @if($isToday)
                                    <span class="px-2 py-0.5 bg-yellow-500/20 border border-yellow-500/30 text-yellow-400 text-xs font-semibold rounded-full">Hoy</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-400 lg:hidden">{{ $dayName['full'] }}</p>
                        </div>

                        <!-- Cuerpo de la tarjeta -->
                        <div class="p-4 flex flex-col items-center text-center min-h-[140px] justify-center">
                            @if (!$schedule->is_open)
                                <!-- Cerrado -->
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-gray-500/20 to-gray-600/20 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                <p class="text-gray-400 font-semibold text-sm">Cerrado</p>
                            @elseif ($schedule->is_24_hours)
                                <!-- 24 horas -->
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-green-500/20 to-emerald-500/20 border-2 border-green-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg shadow-green-500/20">
                                    <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-green-400 font-bold text-base mb-1">24 horas</p>
                                <p class="text-xs text-slate-400">Abierto siempre</p>
                            @else
                                <!-- Horario específico -->
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-yellow-500/20 to-yellow-600/20 border-2 border-yellow-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg shadow-yellow-500/20">
                                    <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="space-y-1">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <p class="text-green-400 font-bold text-base">{{ substr($schedule->opening_time, 0, 5) }}</p>
                                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                        <p class="text-yellow-400 font-bold text-base">{{ substr($schedule->closing_time, 0, 5) }}</p>
                                    </div>
                                    <p class="text-xs text-slate-400">Abierto</p>
                                </div>
                            @endif

                            @if($schedule->notes)
                                <p class="text-xs text-slate-400 mt-2 italic">{{ $schedule->notes }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Nota informativa -->
            <div class="mt-8 glass rounded-xl border border-blue-500/20 p-5 flex items-start gap-4 bg-slate-900/70">
                <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white font-semibold mb-1">Horarios sujetos a cambios</p>
                    <p class="text-sm text-slate-300">Los horarios pueden variar en días feriados. Contactanos para confirmar disponibilidad.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Conócenos con Carrusel -->
    <section id="conocenos" class="py-24 relative">
        @if(empty($theme['hero_background_url']))
        <div class="section-overlay bg-slate-900"></div>
        @endif
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Carrusel de imágenes -->
                <div class="carousel-container h-[500px] shadow-2xl">
                    @foreach ($theme['carousel_images'] as $i => $img)
                        <div class="carousel-slide {{ $i === 0 ? 'active' : '' }}" style="background-image: url('{{ $img }}')"></div>
                    @endforeach

                    <!-- Indicadores -->
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                        <button class="carousel-indicator w-2 h-2 rounded-full bg-white/50 hover:bg-white transition" data-slide="0"></button>
                        <button class="carousel-indicator w-2 h-2 rounded-full bg-white/50 hover:bg-white transition" data-slide="1"></button>
                        <button class="carousel-indicator w-2 h-2 rounded-full bg-white/50 hover:bg-white transition" data-slide="2"></button>
                    </div>
                </div>

                <!-- Contenido -->
                <div class="space-y-6">
                    <div>
                        <p class="text-yellow-400 font-semibold text-sm uppercase tracking-wider mb-3">Sobre nosotros</p>
                        <h2 class="text-4xl md:text-5xl font-bold mb-4">
                            Más que un estacionamiento, tu tranquilidad
                        </h2>
                        <p class="text-lg text-slate-300 leading-relaxed">
                            Nuestras instalaciones techadas, sistema de vigilancia HD y personal capacitado garantizan que tu auto esté seguro mientras disfrutás de tu tiempo.
                        </p>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="glass p-5 rounded-xl bg-slate-900/75">
                            <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold mb-1">Seguridad Total</h3>
                            <p class="text-sm text-slate-400">Cámaras HD, seguro y vigilancia humana permanente</p>
                        </div>

                        <div class="glass p-5 rounded-xl bg-slate-900/75">
                            <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold mb-1">Acceso Rápido</h3>
                            <p class="text-sm text-slate-400">Entrada y salida por ambas calles</p>
                        </div>
                    </div>

                    <p class="pt-2 text-slate-300 text-sm">
                        Atención personalizada, instalaciones iluminadas y convenios con locales de la zona.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tarifas -->
    <section id="tarifas" class="py-24 relative overflow-hidden">
        @if(empty($theme['hero_background_url']))
        <div class="section-overlay bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-yellow-500/5 to-transparent pointer-events-none z-0"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <p class="text-yellow-400 font-semibold text-sm uppercase tracking-wider mb-3">Tarifas</p>
                <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">Precios claros y al instante</h2>
                <p class="text-lg text-slate-300 max-w-3xl mx-auto">
                    Se fracciona cada 30 minutos después de la primera hora.
                </p>
            </div>

            @php
                $badgeByColor = $badgeByColor ?? [
                    'yellow' => 'bg-yellow-500/15 text-yellow-300 border-yellow-500/30',
                    'green' => 'bg-green-500/15 text-green-300 border-green-500/30',
                    'blue' => 'bg-blue-500/15 text-blue-200 border-blue-500/30',
                ];
                $priceByColor = [
                    'yellow' => 'text-yellow-400',
                    'green' => 'text-green-300',
                    'blue' => 'text-blue-300',
                ];
                $borderByColor = [
                    'yellow' => 'border-yellow-500/40 shadow-yellow-500/10',
                    'green' => 'border-green-500/40 shadow-green-500/10',
                    'blue' => 'border-blue-500/40 shadow-blue-500/10',
                ];
                $iconByColor = [
                    'yellow' => 'bg-yellow-500/20 text-yellow-400',
                    'green' => 'bg-green-500/20 text-green-400',
                    'blue' => 'bg-blue-500/20 text-blue-400',
                ];
            @endphp

            <div class="grid md:grid-cols-2 gap-6 mb-10">
                @foreach ($tarifas as $tarifa)
                    <div class="relative group">
                        <div class="absolute inset-0 {{ $borderByColor[$tarifa->color] ?? 'border-white/10' }} bg-gradient-to-br from-white/5 to-transparent rounded-2xl blur-xl group-hover:blur-2xl transition-all"></div>
                        <div class="relative glass p-6 rounded-2xl border-2 {{ $borderByColor[$tarifa->color] ?? 'border-white/10' }} shadow-2xl hover:shadow-3xl transition-all duration-300 hover:-translate-y-1 bg-slate-900/85">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl {{ $iconByColor[$tarifa->color] ?? 'bg-yellow-500/20 text-yellow-400' }} flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-bold">{{ $tarifa->vehicle_type }}</h3>
                                </div>
                            </div>
                            <div class="space-y-3">
                                @if ($tarifa->per_hour)
                                    <div class="bg-slate-950/60 border-2 border-white/10 rounded-xl p-3 hover:bg-slate-950/80 transition-all">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <p class="text-slate-200 font-semibold text-sm">Por hora</p>
                                            </div>
                                            <p class="text-2xl md:text-3xl font-black {{ $priceByColor[$tarifa->color] ?? 'text-yellow-400' }}">{{ $tarifa->per_hour }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if ($tarifa->twelve_hours)
                                    <div class="bg-slate-950/60 border-2 border-white/10 rounded-xl p-3 hover:bg-slate-950/80 transition-all">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                    </svg>
                                                </div>
                                                <p class="text-slate-200 font-semibold text-sm">Estadía 12 hs</p>
                                            </div>
                                            <p class="text-2xl md:text-3xl font-black {{ $priceByColor[$tarifa->color] ?? 'text-yellow-400' }}">{{ $tarifa->twelve_hours }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if ($tarifa->twenty_four_hours)
                                    <div class="bg-slate-950/60 border-2 border-white/10 rounded-xl p-3 hover:bg-slate-950/80 transition-all">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                    </svg>
                                                </div>
                                                <p class="text-slate-200 font-semibold text-sm">Estadía 24 hs</p>
                                            </div>
                                            <p class="text-2xl md:text-3xl font-black {{ $priceByColor[$tarifa->color] ?? 'text-yellow-400' }}">{{ $tarifa->twenty_four_hours }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 glass p-5 md:p-6 rounded-2xl border border-blue-500/20 bg-slate-900/70">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-bold mb-1">Fraccionamiento inteligente</p>
                        <p class="text-sm text-slate-300">Primera hora completa. Luego, cobro cada 30 minutos según la tarifa por hora.</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-gradient-to-r from-yellow-500 to-yellow-600 text-slate-900 rounded-2xl p-5 md:p-6 shadow-lg shadow-yellow-500/25">
                <div class="flex flex-col gap-3">
                    <p class="text-sm font-semibold uppercase tracking-wide">Estadía mensual</p>
                    <h3 class="text-xl md:text-2xl font-bold">Estadía mensual con entrada y salida ilimitada dentro de nuestros horarios operativos</h3>
                    <p class="text-sm text-slate-900/80">Ponete en contacto para consultar disponibilidad</p>
                    <a href="#contacto" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-slate-900/85 text-yellow-300 font-semibold hover:bg-slate-900 transition w-full sm:w-auto">
                        Contactar
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Bonificaciones -->
    <section id="bonificaciones" class="py-24 relative">
        @if(empty($theme['hero_background_url']))
        <div class="section-overlay bg-slate-900"></div>
        @endif
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <p class="text-yellow-400 font-semibold text-sm uppercase tracking-wider mb-3">Bonificaciones</p>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Más beneficios por estacionar con nosotros</h2>
                <p class="text-xl text-slate-300 max-w-3xl mx-auto">
                    Comés en nuestros aliados, sellás el ticket y tenés <span class="text-yellow-400 font-semibold">1 hora gratis de estacionamiento</span>.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($bonificaciones as $bonificacion)
                    <div class="p-4 rounded-2xl transition text-center flex flex-col items-center gap-3">
                        @if($bonificacion->logo_url)
                            {{-- Si tiene logo personalizado, mostrarlo --}}
                            <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-white/10">
                                <img src="{{ $bonificacion->logo_url }}" alt="{{ $bonificacion->name }}" class="w-10 h-10 object-contain">
                            </div>
                        @else
                            {{-- Si no tiene logo, mostrar icono SVG con color --}}
                            <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-white/10 text-{{ $bonificacion->icon_color }}-400">
                                @if($bonificacion->icon_svg)
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                        {!! $bonificacion->icon_svg !!}
                                    </svg>
                                @else
                                    {{-- Icono genérico por defecto --}}
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                @endif
                            </div>
                        @endif
                        <h3 class="text-lg font-semibold">{{ $bonificacion->name }}</h3>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 text-center glass border border-yellow-500/20 p-6 rounded-2xl bg-slate-900/70">
                <p class="text-white mb-2">
                    <span class="text-2xl">💡</span> <strong>¿Cómo obtener tu beneficio?</strong>
                </p>
                <p class="text-sm text-slate-300">
                    Guardá el ticket, pedí que te lo sellen en el restaurante aliado y presentalo al salir para aplicar la hora gratis de estacionamiento.
                </p>
            </div>
        </div>
    </section>

    <!-- Ubicación -->
    <section id="ubicacion" class="py-24 relative overflow-hidden">
        @if(empty($theme['hero_background_url']))
        <div class="section-overlay bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
        @endif
        <!-- Decorative gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 via-transparent to-purple-500/5 pointer-events-none z-0"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass border border-blue-500/20 mb-4">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-blue-400 font-semibold text-xs uppercase tracking-wider">Ubicación</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-white via-slate-100 to-white bg-clip-text text-transparent">¿Dónde estamos?</h2>
                <p class="text-lg text-slate-300 mt-3 max-w-2xl mx-auto">En pleno centro de Lanús, con doble acceso por José María Moreno y Av. Alcorta</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 items-start">
                <!-- Mapa -->
                <div class="glass rounded-2xl border border-white/10 overflow-hidden backdrop-blur-xl shadow-2xl h-[450px] bg-slate-900/80">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3277.470539!2d-58.396697!3d-34.7012693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bccd201b5320ed%3A0x7923eaa939b0106f!2sJos%C3%A9%20Mar%C3%ADa%20Moreno%20165%2C%20B1824MRH%20Lan%C3%BAs%2C%20Provincia%20de%20Buenos%20Aires!5e0!3m2!1ses!2sar!4v1735489200000!5m2!1ses!2sar"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <!-- Información -->
                <div class="space-y-6">
                    <!-- Dirección -->
                    <div class="glass rounded-2xl border border-white/10 p-6 backdrop-blur-xl shadow-lg hover:border-blue-500/30 transition-all duration-300 bg-slate-900/80">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/20">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-white mb-2">Dirección</h3>
                                <p class="text-slate-300 text-base leading-relaxed">
                                    José María Moreno 165<br>
                                    Lanús Centro<br>
                                    Buenos Aires, Argentina
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Cómo llegar -->
                    <div class="glass rounded-2xl border border-white/10 p-6 backdrop-blur-xl shadow-lg hover:border-green-500/30 transition-all duration-300 bg-slate-900/80">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-green-500/20">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-white mb-2">Cómo llegar</h3>
                                <ul class="space-y-2 text-slate-300 text-sm">
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                        <span>Entrada principal por José María Moreno 165 (oficina en la salida a Moreno)</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                        <span>Entrada y salida alternativa por Av. Alcorta</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                        <span>A metros de la estación Lanús</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Botón Waze/Google Maps -->
                    <div class="grid grid-cols-2 gap-4">
                        <a href="https://waze.com/ul?ll=-34.7012693,-58.3941221&navigate=yes" target="_blank" rel="noopener"
                           class="flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 transition shadow-lg shadow-blue-500/20">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C7.8 0 4 3.4 4 8.2c0 5.4 8 15.8 8 15.8s8-10.4 8-15.8C20 3.4 16.2 0 12 0zm0 11c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/>
                            </svg>
                            Abrir en Waze
                        </a>
                        <a href="https://maps.app.goo.gl/RHMnVR6TXGBvsr9A9" target="_blank" rel="noopener"
                           class="flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition shadow-lg shadow-green-500/20">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C7.8 0 4 3.4 4 8.2c0 5.4 8 15.8 8 15.8s8-10.4 8-15.8C20 3.4 16.2 0 12 0zm0 11c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/>
                            </svg>
                            Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="py-24 relative">
        @if(empty($theme['hero_background_url']))
        <div class="section-overlay bg-slate-900"></div>
        @endif
        <div class="max-w-4xl mx-auto px-6 relative z-10">
            <div class="text-center mb-10">
                <p class="text-yellow-400 font-semibold text-sm uppercase tracking-wider mb-3">Contacto</p>
                <h2 class="text-4xl md:text-5xl font-bold mb-3">Contactanos por WhatsApp</h2>
                <p class="text-lg text-slate-300">Escribinos directamente y te respondemos al instante</p>
            </div>

            <div class="glass rounded-2xl border border-green-500/30 p-8 md:p-12 bg-slate-900/80 shadow-2xl shadow-green-500/10">
                <div class="flex flex-col items-center text-center space-y-6">
                    <!-- Icono de WhatsApp grande -->
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-2xl shadow-green-500/40 animate-pulse">
                        <svg class="w-14 h-14 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                    </div>

                    <!-- Título -->
                    <div>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Hablemos por WhatsApp</h3>
                        <p class="text-slate-300 text-base max-w-xl mx-auto">
                            Consultá por tarifas especiales, reservá tu lugar o preguntá lo que necesites. Te respondemos rápidamente.
                        </p>
                    </div>

                    <!-- Botón principal de WhatsApp -->
                    <a href="https://wa.me/{{ $theme['whatsapp_number'] ?? '541123456789' }}?text=Hola%2C%20quiero%20consultar%20sobre%20el%20estacionamiento"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="group inline-flex items-center justify-center gap-3 px-8 py-5 rounded-2xl bg-gradient-to-r from-green-500 to-green-600 text-white font-bold text-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-2xl shadow-green-500/40 hover:shadow-green-500/60 hover:scale-105 w-full md:w-auto">
                        <svg class="w-7 h-7 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        Abrir WhatsApp
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>

                    <!-- Info adicional -->
                    <div class="pt-4 space-y-3">
                        <div class="flex items-center justify-center gap-2 text-slate-400">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-sm">Respuesta inmediata</span>
                        </div>
                        <div class="flex items-center justify-center gap-2 text-slate-400">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm">Atención personalizada</span>
                        </div>
                    </div>

                    <!-- Número visible -->
                    <div class="pt-4 border-t border-white/10 w-full">
                        <p class="text-slate-400 text-sm">O llamanos al</p>
                        <a href="tel:+{{ $theme['whatsapp_number'] ?? '541123456789' }}" class="text-green-400 font-bold text-xl hover:text-green-300 transition">
                            @php
                                $number = $theme['whatsapp_number'] ?? '541123456789';
                                // Format: +54 11 2345-6789
                                if (strlen($number) >= 12 && str_starts_with($number, '54')) {
                                    $formatted = '+' . substr($number, 0, 2) . ' ' . substr($number, 2, 2) . ' ' . substr($number, 4, 4) . '-' . substr($number, 8);
                                } else {
                                    $formatted = '+' . $number;
                                }
                                echo $formatted;
                            @endphp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="footer" class="border-t border-white/10 relative overflow-hidden">
        @if(empty($theme['hero_background_url']))
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900 to-slate-950 z-[-1]"></div>
        @else
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/95 to-slate-950 z-[-1]"></div>
        @endif
        <!-- Decorative gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 via-transparent to-transparent pointer-events-none z-0"></div>

        <div class="max-w-7xl mx-auto px-6 py-16 relative">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Columna 1: Información del negocio -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-yellow-500/20">
                            EM
                        </div>
                        <div>
                            <p class="font-bold text-white text-lg">Estacionamiento Moreno</p>
                            <p class="text-xs text-slate-400">Seguridad y confianza</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Tu vehículo seguro en el corazón de Lanús. Monitoreo 24/7, techado y con las mejores tarifas de la zona.
                    </p>
                </div>

                <!-- Columna 2: Contacto -->
                <div class="space-y-4">
                    <h3 class="text-white font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Contacto
                    </h3>
                    <div class="space-y-3 text-sm">
                        <a href="https://maps.app.goo.gl/RHMnVR6TXGBvsr9A9" target="_blank" class="flex items-start gap-2 text-slate-400 hover:text-yellow-400 transition group">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="group-hover:underline">José María Moreno 165<br>Lanús Centro, Buenos Aires</span>
                        </a>
                        <a href="https://wa.me/{{ $theme['whatsapp_number'] ?? '541123456789' }}" target="_blank" class="flex items-center gap-2 text-slate-400 hover:text-green-400 transition">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            @php
                                $number = $theme['whatsapp_number'] ?? '541123456789';
                                if (strlen($number) >= 12 && str_starts_with($number, '54')) {
                                    echo '+' . substr($number, 0, 2) . ' ' . substr($number, 2, 2) . ' ' . substr($number, 4, 4) . '-' . substr($number, 8);
                                } else {
                                    echo '+' . $number;
                                }
                            @endphp
                        </a>
                        <a href="mailto:info@estacionamientomoreno.com" class="flex items-center gap-2 text-slate-400 hover:text-yellow-400 transition">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            info@estacionamientomoreno.com
                        </a>
                    </div>
                </div>

                <!-- Columna 3: Enlaces rápidos -->
                <div class="space-y-4">
                    <h3 class="text-white font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Enlaces Rápidos
                    </h3>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="#inicio" class="text-slate-400 hover:text-yellow-400 transition flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-yellow-400 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Inicio
                            </a>
                        </li>
                        <li>
                            <a href="#conocenos" class="text-slate-400 hover:text-yellow-400 transition flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-yellow-400 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Conócenos
                            </a>
                        </li>
                        <li>
                            <a href="#horarios" class="text-slate-400 hover:text-yellow-400 transition flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-yellow-400 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Horarios
                            </a>
                        </li>
                        <li>
                            <a href="#tarifas" class="text-slate-400 hover:text-yellow-400 transition flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-yellow-400 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Tarifas
                            </a>
                        </li>
                        <li>
                            <a href="#ubicacion" class="text-slate-400 hover:text-yellow-400 transition flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-yellow-400 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Ubicación
                            </a>
                        </li>
                        <li>
                            <a href="#contacto" class="text-slate-400 hover:text-yellow-400 transition flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-yellow-400 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Contacto
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Columna 4: Horarios y Redes -->
                <div class="space-y-4">
                    <h3 class="text-white font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Horarios
                    </h3>
                    <div class="text-sm space-y-2">
                        @php
                            $todaySchedule = $weeklySchedules->where('day_of_week', now()->dayOfWeek)->first();
                            $isCurrentlyOpen = false;

                            if ($todaySchedule && $todaySchedule->is_open) {
                                if ($todaySchedule->is_24_hours) {
                                    // Si es 24 horas, siempre está abierto
                                    $isCurrentlyOpen = true;
                                } else {
                                    $currentTime = now()->format('H:i');
                                    $openingTime = substr($todaySchedule->opening_time, 0, 5);
                                    $closingTime = substr($todaySchedule->closing_time, 0, 5);

                                    // Manejar horarios que cruzan medianoche (ej: 20:00 a 05:00)
                                    if ($closingTime < $openingTime) {
                                        $isCurrentlyOpen = ($currentTime >= $openingTime || $currentTime < $closingTime);
                                    } else {
                                        $isCurrentlyOpen = ($currentTime >= $openingTime && $currentTime < $closingTime);
                                    }
                                }
                            }
                        @endphp
                        @if($isCurrentlyOpen)
                            <div class="flex items-center gap-2 text-green-400">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span class="font-semibold">Abierto ahora</span>
                            </div>
                            @if($todaySchedule->is_24_hours)
                                <p class="text-slate-400">Horario: 24 horas</p>
                            @else
                                <p class="text-slate-400">Horario: {{ substr($todaySchedule->opening_time, 0, 5) }} - {{ substr($todaySchedule->closing_time, 0, 5) }}</p>
                            @endif
                        @else
                            <div class="flex items-center gap-2 text-red-400">
                                <div class="w-2 h-2 bg-red-400 rounded-full"></div>
                                <span class="font-semibold">Cerrado ahora</span>
                            </div>
                        @endif
                        <a href="#horarios" class="inline-block text-yellow-400 hover:text-yellow-300 text-xs underline mt-1">
                            Ver todos los horarios →
                        </a>
                    </div>

                    <div class="pt-4">
                        <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-3">Seguinos</h4>
                        <div class="flex gap-3">
                            <a href="{{ $theme['instagram_url'] ?? 'https://instagram.com' }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-gradient-to-br hover:from-purple-500 hover:to-pink-500 hover:border-transparent transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <a href="https://wa.me/{{ $theme['whatsapp_number'] ?? '541123456789' }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-green-500 hover:border-transparent transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="pt-8 border-t border-white/10">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-500">
                    <p>© {{ date('Y') }} Estacionamiento Moreno. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Botón flotante de WhatsApp -->
    <a href="https://wa.me/{{ $theme['whatsapp_number'] ?? '541123456789' }}?text=Hola%2C%20quiero%20consultar%20sobre%20el%20estacionamiento"
       id="whatsapp-float"
       target="_blank"
       rel="noopener noreferrer"
       style="transition: opacity 0.3s ease, transform 0.3s ease;"
       class="fixed bottom-6 right-6 z-50 w-16 h-16 bg-green-500 rounded-full flex items-center justify-center shadow-2xl hover:bg-green-600 hover:scale-110 transition-all duration-300 group"
       aria-label="Contactar por WhatsApp">
        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>

    <script>
        // Menú móvil
        document.getElementById('menu-toggle').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Smooth scroll para los links del header
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Cerrar menú móvil si está abierto
                    document.getElementById('mobile-menu').classList.add('hidden');
                }
            });
        });

        // Carrusel de imágenes en "Conócenos"
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.carousel-indicator');
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(ind => ind.classList.remove('bg-white'));
            indicators.forEach(ind => ind.classList.add('bg-white/50'));
            
            slides[index].classList.add('active');
            indicators[index].classList.remove('bg-white/50');
            indicators[index].classList.add('bg-white');
        }

        // Auto-rotate carrusel cada 5 segundos
        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }, 5000);

        // Click en indicadores
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

        // Ocultar botón de WhatsApp en el footer
        const whatsappButton = document.getElementById('whatsapp-float');
        const footer = document.getElementById('footer');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    whatsappButton.style.opacity = '0';
                    whatsappButton.style.pointerEvents = 'none';
                } else {
                    whatsappButton.style.opacity = '1';
                    whatsappButton.style.pointerEvents = 'auto';
                }
            });
        }, {
            threshold: 0.1
        });

        observer.observe(footer);
    </script>
    </div>
</body>
</html>
