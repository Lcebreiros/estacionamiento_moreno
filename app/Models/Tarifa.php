<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_type',
        'badge_label',
        'color',
        'per_hour',
        'twelve_hours',
        'twenty_four_hours',
        'sort_order',
    ];
}
