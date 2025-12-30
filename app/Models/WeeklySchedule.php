<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklySchedule extends Model
{
    protected $fillable = [
        'day_of_week',
        'is_open',
        'opening_time',
        'closing_time',
        'is_24_hours',
        'notes',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'is_24_hours' => 'boolean',
    ];

    public static function getDayNames(): array
    {
        return [
            0 => 'Domingo',
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
        ];
    }

    public function getDayNameAttribute(): string
    {
        return self::getDayNames()[$this->day_of_week] ?? '';
    }

    public function getFormattedScheduleAttribute(): string
    {
        if (!$this->is_open) {
            return 'Cerrado';
        }

        if ($this->is_24_hours) {
            return '24 horas';
        }

        return $this->opening_time ?
            substr($this->opening_time, 0, 5) . ' - ' . substr($this->closing_time, 0, 5) :
            'Cerrado';
    }
}
