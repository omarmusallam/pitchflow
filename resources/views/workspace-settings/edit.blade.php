<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Workspace settings</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Company & Branding
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Configure your workspace identity, contact details, brand presentation, and proposal defaults.
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

    <form action="{{ route('workspace-settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Workspace Identity</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Core company details</h3>
                </div>

                <div class="mt-8 grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Workspace
                            Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $workspace->name) }}"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="brand_name" class="mb-2 block text-sm font-semibold text-slate-700">Brand
                            Name</label>
                        <input type="text" name="brand_name" id="brand_name"
                            value="{{ old('brand_name', $workspace->brand_name) }}" placeholder="e.g. Bright Studio"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="primary_color" class="mb-2 block text-sm font-semibold text-slate-700">Primary
                            Color</label>
                        <input type="text" name="primary_color" id="primary_color"
                            value="{{ old('primary_color', $workspace->primary_color) }}" placeholder="#4F46E5"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="accent_color" class="mb-2 block text-sm font-semibold text-slate-700">Accent
                            Color</label>
                        <input type="text" name="accent_color" id="accent_color"
                            value="{{ old('accent_color', $workspace->accent_color) }}" placeholder="#0F172A"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Company Contact</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Business communication details</h3>
                </div>

                <div class="mt-8 grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="company_email" class="mb-2 block text-sm font-semibold text-slate-700">Company
                            Email</label>
                        <input type="email" name="company_email" id="company_email"
                            value="{{ old('company_email', $workspace->company_email) }}"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="company_phone" class="mb-2 block text-sm font-semibold text-slate-700">Company
                            Phone</label>
                        <input type="text" name="company_phone" id="company_phone"
                            value="{{ old('company_phone', $workspace->company_phone) }}"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="md:col-span-2">
                        <label for="company_website"
                            class="mb-2 block text-sm font-semibold text-slate-700">Website</label>
                        <input type="text" name="company_website" id="company_website"
                            value="{{ old('company_website', $workspace->company_website) }}"
                            placeholder="https://example.com"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="md:col-span-2">
                        <label for="company_address"
                            class="mb-2 block text-sm font-semibold text-slate-700">Address</label>
                        <input type="text" name="company_address" id="company_address"
                            value="{{ old('company_address', $workspace->company_address) }}"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="company_city" class="mb-2 block text-sm font-semibold text-slate-700">City</label>
                        <input type="text" name="company_city" id="company_city"
                            value="{{ old('company_city', $workspace->company_city) }}"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="company_country"
                            class="mb-2 block text-sm font-semibold text-slate-700">Country</label>
                        <input type="text" name="company_country" id="company_country"
                            value="{{ old('company_country', $workspace->company_country) }}"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Proposal Defaults</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Default content behavior</h3>
                </div>

                <div class="mt-8 space-y-5">
                    <div>
                        <label for="default_validity_days"
                            class="mb-2 block text-sm font-semibold text-slate-700">Default Validity Days</label>
                        <input type="number" name="default_validity_days" id="default_validity_days" min="1"
                            max="90"
                            value="{{ old('default_validity_days', $workspace->default_validity_days) }}"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="proposal_footer" class="mb-2 block text-sm font-semibold text-slate-700">Proposal
                            Footer</label>
                        <textarea name="proposal_footer" id="proposal_footer" rows="5"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('proposal_footer', $workspace->proposal_footer) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Email & Branding Rules</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Outbound identity settings</h3>
                </div>

                <div class="mt-8 space-y-5">
                    <div>
                        <label for="email_signature" class="mb-2 block text-sm font-semibold text-slate-700">Email
                            Signature</label>
                        <textarea name="email_signature" id="email_signature" rows="6"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('email_signature', $workspace->email_signature) }}</textarea>
                    </div>

                    <label class="flex items-center gap-3 rounded-2xl border border-slate-200 px-4 py-3">
                        <input type="checkbox" name="show_branding_on_public_pages" value="1"
                            {{ old('show_branding_on_public_pages', $workspace->show_branding_on_public_pages) ? 'checked' : '' }}
                            class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="text-sm font-medium text-slate-700">Show branding on public proposal pages</span>
                    </label>

                    <label class="flex items-center gap-3 rounded-2xl border border-slate-200 px-4 py-3">
                        <input type="checkbox" name="show_branding_on_pdf" value="1"
                            {{ old('show_branding_on_pdf', $workspace->show_branding_on_pdf) ? 'checked' : '' }}
                            class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="text-sm font-medium text-slate-700">Show branding on exported PDF documents</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                Save Workspace Settings
            </button>
        </div>
    </form>
</x-app-layout>
