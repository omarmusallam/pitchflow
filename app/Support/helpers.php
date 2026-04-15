<?php

use App\Models\PlatformSetting;

if (! function_exists('platform_settings')) {
    function platform_settings(): PlatformSetting
    {
        return PlatformSetting::current();
    }
}
