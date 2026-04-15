<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Workspace;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $workspace = Workspace::first();

        if (! $workspace) {
            $this->command->warn('No workspace found. Seed aborted.');
            return;
        }

        $clients = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@brightstudio.co',
                'company' => 'Bright Studio',
                'phone' => '+1 415 555 1023',
                'notes' => 'Interested in a full website redesign for a creative agency. Prefers modern minimal style and fast turnaround.',
            ],
            [
                'name' => 'Michael Carter',
                'email' => 'michael@northpeakmedia.com',
                'company' => 'North Peak Media',
                'phone' => '+1 646 555 1189',
                'notes' => 'Needs proposal for branding package and landing page design. Budget is flexible if quality is strong.',
            ],
            [
                'name' => 'Lina Haddad',
                'email' => 'lina.haddad@olivecommerce.com',
                'company' => 'Olive Commerce',
                'phone' => '+970 599 221 884',
                'notes' => 'Looking for eCommerce UX improvements and product page optimization. Wants clear milestone-based pricing.',
            ],
            [
                'name' => 'Daniel Brooks',
                'email' => 'daniel@brooksventures.io',
                'company' => 'Brooks Ventures',
                'phone' => '+44 20 7946 2841',
                'notes' => 'Requested web app dashboard design and frontend implementation. Focus on SaaS-style clean UI.',
            ],
            [
                'name' => 'Nour Khalil',
                'email' => 'nour.khalil@novafit.app',
                'company' => 'NovaFit',
                'phone' => '+971 50 883 4412',
                'notes' => 'Startup founder needing MVP website and investor pitch landing page. Prefers weekly updates and quick communication.',
            ],
            [
                'name' => 'Adam Wilson',
                'email' => 'adam@wilsonlegalgroup.com',
                'company' => 'Wilson Legal Group',
                'phone' => '+1 312 555 4430',
                'notes' => 'Wants a professional corporate website with service pages, blog, and consultation form. Values trust-building design.',
            ],
            [
                'name' => 'Yasmeen Saleh',
                'email' => 'yasmeen@crafthouseinteriors.com',
                'company' => 'Craft House Interiors',
                'phone' => '+962 79 882 1433',
                'notes' => 'Interested in portfolio website redesign with elegant visuals and project showcase sections.',
            ],
            [
                'name' => 'Omar Faris',
                'email' => 'omar.faris@digitbridge.co',
                'company' => 'DigitBridge',
                'phone' => '+966 54 991 6720',
                'notes' => 'Needs proposal for custom CRM frontend and admin panel. Wants modular pricing and optional maintenance plan.',
            ],
            [
                'name' => 'Emily Turner',
                'email' => 'emily.turner@launchgrid.io',
                'company' => 'LaunchGrid',
                'phone' => '+1 718 555 7721',
                'notes' => 'Requested a growth-focused landing page with strong CTA structure and copywriting suggestions.',
            ],
            [
                'name' => 'Khaled Mansour',
                'email' => 'khaled@eduvisionacademy.org',
                'company' => 'EduVision Academy',
                'phone' => '+20 100 667 8124',
                'notes' => 'Looking for educational platform website refresh with course listing pages and student onboarding flow.',
            ],
        ];

        foreach ($clients as $clientData) {
            Client::updateOrCreate(
                [
                    'workspace_id' => $workspace->id,
                    'email' => $clientData['email'],
                ],
                [
                    'workspace_id' => $workspace->id,
                    'name' => $clientData['name'],
                    'company' => $clientData['company'],
                    'phone' => $clientData['phone'],
                    'notes' => $clientData['notes'],
                ]
            );
        }

        $this->command->info('Demo clients seeded successfully.');
    }
}
