<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'primary_color',
        'hero_background_url',
        'logo_url',
        'carousel_images',
        'whatsapp_number',
        'instagram_url',
    ];

    protected $casts = [
        'value' => 'array',
        'carousel_images' => 'array',
    ];
}
