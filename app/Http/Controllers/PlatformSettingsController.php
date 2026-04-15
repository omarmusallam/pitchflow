<?php

namespace App\Http\Controllers;

use App\Models\PlatformSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PlatformSettingsController extends Controller
{
    public function edit(): View
    {
        $settings = PlatformSetting::current();

        return view('platform-settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $settings = PlatformSetting::current();

        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:255'],
            'app_tagline' => ['nullable', 'string', 'max:255'],
            'support_email' => ['nullable', 'email', 'max:255'],
            'platform_url' => ['nullable', 'string', 'max:255'],

            'primary_color' => ['nullable', 'string', 'max:20'],
            'accent_color' => ['nullable', 'string', 'max:20'],

            'default_meta_title' => ['nullable', 'string', 'max:255'],
            'default_meta_description' => ['nullable', 'string'],

            'show_platform_branding' => ['nullable', 'boolean'],

            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:4096'],
            'favicon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,ico', 'max:4096'],
        ]);

        $data = [
            'app_name' => $validated['app_name'],
            'app_tagline' => $validated['app_tagline'] ?? null,
            'support_email' => $validated['support_email'] ?? null,
            'platform_url' => $validated['platform_url'] ?? null,
            'primary_color' => $validated['primary_color'] ?? null,
            'accent_color' => $validated['accent_color'] ?? null,
            'default_meta_title' => $validated['default_meta_title'] ?? null,
            'default_meta_description' => $validated['default_meta_description'] ?? null,
            'show_platform_branding' => $request->boolean('show_platform_branding'),
        ];

        if ($request->hasFile('logo')) {
            if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
                Storage::disk('public')->delete($settings->logo_path);
            }

            $data['logo_path'] = $request->file('logo')->store('platform', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon_path && Storage::disk('public')->exists($settings->favicon_path)) {
                Storage::disk('public')->delete($settings->favicon_path);
            }

            $data['favicon_path'] = $request->file('favicon')->store('platform', 'public');
        }

        $settings->update($data);

        return redirect()
            ->route('platform-settings.edit')
            ->with('success', 'Platform settings updated successfully.');
    }
}
