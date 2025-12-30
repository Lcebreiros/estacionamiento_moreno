<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class ThemeSettings
{
    private const FILE_PATH = 'private/theme.json';
    private const LEGACY_FILE_PATH = 'private/private/theme.json';

    public static function get(): array
    {
        $defaults = [
            'primary_color' => '#eab308',
            'hero_background_url' => null,
            'logo_url' => null,
            'carousel_images' => [
                'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=800',
                'https://images.unsplash.com/photo-1590674899484-d5640e854abe?w=800',
                'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=800',
            ],
            'whatsapp_number' => '541123456789',
            'instagram_url' => 'https://instagram.com',
        ];

        $stored = self::readFromDb() ?? self::readFromFile() ?? [];

        $mergeCarousel = self::mergeCarouselImages($defaults['carousel_images'], $stored['carousel_images'] ?? []);

        return [
            'primary_color' => $stored['primary_color'] ?? $defaults['primary_color'],
            'hero_background_url' => $stored['hero_background_url'] ?? $defaults['hero_background_url'],
            'logo_url' => $stored['logo_url'] ?? $defaults['logo_url'],
            'carousel_images' => $mergeCarousel,
            'whatsapp_number' => $stored['whatsapp_number'] ?? $defaults['whatsapp_number'],
            'instagram_url' => $stored['instagram_url'] ?? $defaults['instagram_url'],
        ];
    }

    public static function store(array $data): void
    {
        // Persist in DB and fall back to file if DB is unavailable
        try {
            self::writeToDb($data);
        } catch (\Throwable $e) {
            // Ignore DB failure, we still write to file below
        }

        self::writeToFile($data);
    }

    public static function publicUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }

    private static function mergeCarouselImages(array $defaults, array $stored): array
    {
        $merged = [];
        for ($i = 0; $i < 3; $i++) {
            $merged[] = $stored[$i] ?? $defaults[$i] ?? null;
        }

        return $merged;
    }

    private static function readFromDb(): ?array
    {
        try {
            $record = SiteSetting::first();
            if (! $record) {
                return null;
            }

            return [
                'primary_color' => $record->primary_color,
                'hero_background_url' => $record->hero_background_url,
                'logo_url' => $record->logo_url ?? null,
                'carousel_images' => $record->carousel_images,
                'whatsapp_number' => $record->whatsapp_number ?? null,
                'instagram_url' => $record->instagram_url ?? null,
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }

    private static function writeToDb(array $data): void
    {
        $record = SiteSetting::first() ?? new SiteSetting();
        $record->primary_color = $data['primary_color'] ?? '#eab308';
        $record->hero_background_url = $data['hero_background_url'] ?? null;
        $record->logo_url = $data['logo_url'] ?? null;
        $record->carousel_images = $data['carousel_images'] ?? [];
        $record->whatsapp_number = $data['whatsapp_number'] ?? null;
        $record->instagram_url = $data['instagram_url'] ?? null;
        $record->save();
    }

    private static function readFromFile(): ?array
    {
        try {
            $candidates = [];

            if (Storage::disk('local')->exists(self::FILE_PATH)) {
                $candidates[] = [
                    'path' => self::FILE_PATH,
                    'mtime' => Storage::disk('local')->lastModified(self::FILE_PATH),
                ];
            }

            // Compat: leer archivo legado si existe (algunas escrituras previas lo dejaron ahí)
            if (Storage::disk('local')->exists(self::LEGACY_FILE_PATH)) {
                $candidates[] = [
                    'path' => self::LEGACY_FILE_PATH,
                    'mtime' => Storage::disk('local')->lastModified(self::LEGACY_FILE_PATH),
                ];
            }

            if (empty($candidates)) {
                return null;
            }

            // Usar el archivo más reciente
            usort($candidates, fn ($a, $b) => $b['mtime'] <=> $a['mtime']);
            $path = $candidates[0]['path'];

            $json = Storage::disk('local')->get($path);
            $data = json_decode($json, true);

            return is_array($data) ? $data : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    private static function writeToFile(array $data): void
    {
        try {
            Storage::disk('local')->put(self::FILE_PATH, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            // Mantener también el path legado por compatibilidad con datos previos
            Storage::disk('local')->put(self::LEGACY_FILE_PATH, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (\Throwable $e) {
            // Swallow file write issues to avoid breaking UI
        }
    }
}
