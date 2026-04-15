<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Platform settings</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    App Identity & Branding
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Configure the core identity of PitchFlow as a product and platform.
                </p>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div
            class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
            <ul class="list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('platform-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Platform Identity</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Core product details</h3>
                </div>

                <div class="mt-8 grid gap-5">
                    <div>
                        <label for="app_name" class="mb-2 block text-sm font-semibold text-slate-700">App Name</label>
                        <input type="text" name="app_name" id="app_name"
                            value="{{ old('app_name', $settings->app_name) }}"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="app_tagline" class="mb-2 block text-sm font-semibold text-slate-700">Tagline</label>
                        <input type="text" name="app_tagline" id="app_tagline"
                            value="{{ old('app_tagline', $settings->app_tagline) }}"
                            placeholder="Proposal Management Platform"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="support_email" class="mb-2 block text-sm font-semibold text-slate-700">Support
                            Email</label>
                        <input type="email" name="support_email" id="support_email"
                            value="{{ old('support_email', $settings->support_email) }}"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="platform_url" class="mb-2 block text-sm font-semibold text-slate-700">Platform
                            URL</label>
                        <input type="text" name="platform_url" id="platform_url"
                            value="{{ old('platform_url', $settings->platform_url) }}"
                            placeholder="https://pitchflow.app"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Brand Colors</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Platform visual identity</h3>
                </div>

                <div class="mt-8 grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="primary_color" class="mb-2 block text-sm font-semibold text-slate-700">Primary
                            Color</label>
                        <input type="text" name="primary_color" id="primary_color"
                            value="{{ old('primary_color', $settings->primary_color) }}" placeholder="#4F46E5"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="accent_color" class="mb-2 block text-sm font-semibold text-slate-700">Accent
                            Color</label>
                        <input type="text" name="accent_color" id="accent_color"
                            value="{{ old('accent_color', $settings->accent_color) }}" placeholder="#0F172A"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="flex items-center gap-3 rounded-2xl border border-slate-200 px-4 py-3">
                            <input type="checkbox" name="show_platform_branding" value="1"
                                {{ old('show_platform_branding', $settings->show_platform_branding) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm font-medium text-slate-700">Show PitchFlow branding inside the
                                platform</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">SEO Defaults</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Default platform metadata</h3>
                </div>

                <div class="mt-8 space-y-5">
                    <div>
                        <label for="default_meta_title" class="mb-2 block text-sm font-semibold text-slate-700">Default
                            Meta Title</label>
                        <input type="text" name="default_meta_title" id="default_meta_title"
                            value="{{ old('default_meta_title', $settings->default_meta_title) }}"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="default_meta_description"
                            class="mb-2 block text-sm font-semibold text-slate-700">Default Meta Description</label>
                        <textarea name="default_meta_description" id="default_meta_description" rows="5"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('default_meta_description', $settings->default_meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Logo & Favicon</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Visual assets</h3>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="logo" class="mb-2 block text-sm font-semibold text-slate-700">Platform
                            Logo</label>
                        <input type="file" name="logo" id="logo" accept=".png,.jpg,.jpeg,.webp,.svg"
                            class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm file:mr-4 file:rounded-xl file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">

                        <div class="mt-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-4">
                            @if ($settings->logo_path)
                                <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Platform logo"
                                    class="h-16 w-auto object-contain">
                            @else
                                <p class="text-sm text-slate-500">No logo uploaded yet.</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label for="favicon" class="mb-2 block text-sm font-semibold text-slate-700">Favicon</label>
                        <input type="file" name="favicon" id="favicon" accept=".png,.jpg,.jpeg,.webp,.ico"
                            class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm file:mr-4 file:rounded-xl file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">

                        <div class="mt-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-4">
                            @if ($settings->favicon_path)
                                <img src="{{ asset('storage/' . $settings->favicon_path) }}" alt="Platform favicon"
                                    class="h-12 w-12 rounded-xl object-cover">
                            @else
                                <p class="text-sm text-slate-500">No favicon uploaded yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                Save Platform Settings
            </button>
        </div>
    </form>
</x-app-layout>
