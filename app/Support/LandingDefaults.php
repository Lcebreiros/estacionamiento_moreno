<?php

namespace App\Support;

class LandingDefaults
{
    public static function horarios(): array
    {
        return [
            [
                'name' => 'Accesos',
                'badge_label' => '24/7',
                'color' => 'green',
                'title' => 'Accesos',
                'description' => 'Entrada y salida automatizada todo el día, todos los días.',
                'items' => [
                    'Personal de guardia permanente',
                    'Iluminación y cámaras HD activas',
                    'Sellado de ticket en locales aliados',
                ],
                'sort_order' => 0,
            ],
            [
                'name' => 'Caja y consultas',
                'badge_label' => 'Atención',
                'color' => 'yellow',
                'title' => 'Caja y consultas',
                'description' => 'Personal en sitio para cobros y asistencia.',
                'items' => [
                    'Lunes a viernes: 07:00 a 23:00',
                    'Sábados: 08:00 a 01:00',
                    'Domingos y feriados: 09:00 a 22:00',
                ],
                'sort_order' => 1,
            ],
            [
                'name' => 'Pago y sellado',
                'badge_label' => 'Recordatorio',
                'color' => 'blue',
                'title' => 'Pago y sellado',
                'description' => 'Aboná con tarjeta o transferencia. Para la bonificación:',
                'items' => [
                    'Pedí el sellado del ticket en el restaurante aliado.',
                    'Presentalo al salir para aplicar la hora gratis.',
                    'Consultá en caja por estadías prolongadas.',
                ],
                'sort_order' => 2,
            ],
        ];
    }

    public static function tarifas(): array
    {
        return [
            [
                'vehicle_type' => 'Auto',
                'badge_label' => 'Techado',
                'color' => 'yellow',
                'per_hour' => '$5.000',
                'twelve_hours' => '$20.000',
                'twenty_four_hours' => '$40.000',
                'sort_order' => 0,
            ],
            [
                'vehicle_type' => 'Camioneta',
                'badge_label' => 'Techado',
                'color' => 'yellow',
                'per_hour' => '$6.000',
                'twelve_hours' => '$24.000',
                'twenty_four_hours' => '$48.000',
                'sort_order' => 1,
            ],
        ];
    }

    public static function bonificaciones(): array
    {
        return [
            [
                'name' => 'Parrilla Don Julio',
                'icon_color' => 'red',
                'icon_svg' => '<path d="M8.1 13.34l2.83-2.83L3.91 3.5c-1.56 1.56-1.56 4.09 0 5.66l4.19 4.18zm6.78-1.81c1.53.71 3.68.21 5.27-1.38 1.91-1.91 2.28-4.65.81-6.12-1.46-1.46-4.2-1.1-6.12.81-1.59 1.59-2.09 3.74-1.38 5.27L3.7 19.87l1.41 1.41L12 14.41l6.88 6.88 1.41-1.41L13.41 13l1.47-1.47z"/>',
                'sort_order' => 0,
            ],
            [
                'name' => 'Café Moreno',
                'icon_color' => 'yellow',
                'icon_svg' => '<path d="M2 21h19v-3H2v3zM20 8H4V6h16v2zm0-5H4c-1.1 0-2 .9-2 2v3c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 7H5v9h14v-9z"/>',
                'sort_order' => 1,
            ],
            [
                'name' => 'Pizzería Napolitana',
                'icon_color' => 'blue',
                'icon_svg' => '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>',
                'sort_order' => 2,
            ],
            [
                'name' => 'Bistró Verde',
                'icon_color' => 'emerald',
                'icon_svg' => '<path d="M16 6v8h3v8h2V2c-2.76 0-5 2.24-5 4zm-5 3H9V2H7v7H5V2H3v7c0 2.21 1.79 4 4 4v9h2v-9c2.21 0 4-1.79 4-4V2h-2v7z"/>',
                'sort_order' => 3,
            ],
        ];
    }
}
