<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkspaceSettingsController extends Controller
{
    public function edit(): View
    {
        $workspace = auth()->user()->workspace;

        abort_unless($workspace, 404);

        return view('workspace-settings.edit', compact('workspace'));
    }

    public function update(Request $request): RedirectResponse
    {
        $workspace = auth()->user()->workspace;

        abort_unless($workspace, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'primary_color' => ['nullable', 'string', 'max:20'],
            'accent_color' => ['nullable', 'string', 'max:20'],

            'company_email' => ['nullable', 'email', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:255'],
            'company_website' => ['nullable', 'string', 'max:255'],

            'company_address' => ['nullable', 'string', 'max:255'],
            'company_city' => ['nullable', 'string', 'max:255'],
            'company_country' => ['nullable', 'string', 'max:255'],

            'email_signature' => ['nullable', 'string'],
            'proposal_footer' => ['nullable', 'string'],

            'default_validity_days' => ['required', 'integer', 'min:1', 'max:90'],
            'show_branding_on_public_pages' => ['nullable', 'boolean'],
            'show_branding_on_pdf' => ['nullable', 'boolean'],
        ]);

        $workspace->update([
            ...$validated,
            'show_branding_on_public_pages' => $request->boolean('show_branding_on_public_pages'),
            'show_branding_on_pdf' => $request->boolean('show_branding_on_pdf'),
        ]);

        return redirect()
            ->route('workspace-settings.edit')
            ->with('success', 'Workspace settings updated successfully.');
    }
}
