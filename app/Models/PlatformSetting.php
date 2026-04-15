<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformSetting extends Model
{
    protected $fillable = [
        'app_name',
        'app_tagline',
        'support_email',
        'platform_url',
        'logo_path',
        'favicon_path',
        'primary_color',
        'accent_color',
        'default_meta_title',
        'default_meta_description',
        'show_platform_branding',
    ];

    protected $casts = [
        'show_platform_branding' => 'boolean',
    ];

    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'app_name' => 'PitchFlow',
                'app_tagline' => 'Proposal Management Platform',
                'show_platform_branding' => true,
            ]
        );
    }
}
