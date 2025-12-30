<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'badge_label',
        'color',
        'title',
        'description',
        'items',
        'sort_order',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}
