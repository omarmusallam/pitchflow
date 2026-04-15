<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Proposal;
use App\Models\Workspace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProposalSeeder extends Seeder
{
    public function run(): void
    {
        $workspace = Workspace::with('clients')->first();

        if (! $workspace) {
            $this->command->warn('No workspace found. Proposal seeding aborted.');
            return;
        }

        if ($workspace->clients->isEmpty()) {
            $this->command->warn('No clients found for this workspace. Proposal seeding aborted.');
            return;
        }

        $clients = $workspace->clients->keyBy('email');

        $proposals = [
            [
                'client_email' => 'sarah.johnson@brightstudio.co',
                'title' => 'Bright Studio Website Redesign Proposal',
                'status' => 'draft',
                'intro_message' => 'Thank you for the opportunity to prepare this proposal for Bright Studio. This document outlines a complete redesign approach focused on visual clarity, stronger positioning, and an improved conversion-oriented user experience.',
                'valid_until' => Carbon::now()->addDays(14),
                'subtotal' => 3200,
                'discount' => 200,
                'total' => 3000,
                'notes' => 'Client is quality-focused and open to a premium design direction.',
            ],
            [
                'client_email' => 'michael@northpeakmedia.com',
                'title' => 'North Peak Media Branding & Landing Page Proposal',
                'status' => 'sent',
                'intro_message' => 'This proposal covers a branding refresh and a high-converting landing page tailored for North Peak Media. The goal is to improve positioning, trust, and lead generation.',
                'valid_until' => Carbon::now()->addDays(10),
                'subtotal' => 2100,
                'discount' => 100,
                'total' => 2000,
                'notes' => 'Client asked for a fast kickoff if approved.',
            ],
            [
                'client_email' => 'lina.haddad@olivecommerce.com',
                'title' => 'Olive Commerce UX Optimization Proposal',
                'status' => 'viewed',
                'intro_message' => 'This proposal focuses on improving the eCommerce experience for Olive Commerce through stronger product page structure, cleaner flows, and more persuasive UX elements.',
                'valid_until' => Carbon::now()->addDays(7),
                'subtotal' => 2800,
                'discount' => 300,
                'total' => 2500,
                'notes' => 'Potential upsell later: CRO audit and analytics setup.',
            ],
            [
                'client_email' => 'daniel@brooksventures.io',
                'title' => 'Brooks Ventures SaaS Dashboard Proposal',
                'status' => 'accepted',
                'intro_message' => 'Thank you for considering this proposal for the Brooks Ventures dashboard project. This scope includes interface design, frontend implementation, and workflow-oriented dashboard architecture.',
                'valid_until' => Carbon::now()->addDays(5),
                'subtotal' => 4600,
                'discount' => 600,
                'total' => 4000,
                'notes' => 'Accepted client. Good candidate for future retainer.',
            ],
            [
                'client_email' => 'nour.khalil@novafit.app',
                'title' => 'NovaFit MVP Website & Investor Landing Page Proposal',
                'status' => 'draft',
                'intro_message' => 'This proposal presents a focused MVP website structure for NovaFit, including a startup-ready landing experience, product explanation sections, and investor-facing messaging.',
                'valid_until' => Carbon::now()->addDays(12),
                'subtotal' => 3500,
                'discount' => 0,
                'total' => 3500,
                'notes' => 'Founder wants frequent communication and weekly progress updates.',
            ],
            [
                'client_email' => 'adam@wilsonlegalgroup.com',
                'title' => 'Wilson Legal Group Corporate Website Proposal',
                'status' => 'rejected',
                'intro_message' => 'This proposal outlines a corporate website experience for Wilson Legal Group, with a focus on trust, professionalism, practice area structure, and lead capture.',
                'valid_until' => Carbon::now()->subDays(2),
                'subtotal' => 3900,
                'discount' => 400,
                'total' => 3500,
                'notes' => 'Rejected due to budget timing, not quality concerns.',
            ],
            [
                'client_email' => 'yasmeen@crafthouseinteriors.com',
                'title' => 'Craft House Interiors Portfolio Redesign Proposal',
                'status' => 'sent',
                'intro_message' => 'This proposal is designed to reposition Craft House Interiors through a premium visual portfolio, stronger project storytelling, and more elegant browsing experience.',
                'valid_until' => Carbon::now()->addDays(9),
                'subtotal' => 2700,
                'discount' => 200,
                'total' => 2500,
                'notes' => 'Visual direction matters more than speed for this client.',
            ],
            [
                'client_email' => 'omar.faris@digitbridge.co',
                'title' => 'DigitBridge CRM Admin Panel Proposal',
                'status' => 'viewed',
                'intro_message' => 'This document outlines the frontend architecture and interface proposal for a custom CRM admin panel tailored to DigitBridge operational workflows.',
                'valid_until' => Carbon::now()->addDays(11),
                'subtotal' => 5200,
                'discount' => 700,
                'total' => 4500,
                'notes' => 'Client may later request maintenance and support add-on.',
            ],
            [
                'client_email' => 'emily.turner@launchgrid.io',
                'title' => 'LaunchGrid Conversion Landing Page Proposal',
                'status' => 'accepted',
                'intro_message' => 'This proposal covers a growth-focused landing page for LaunchGrid, including structure strategy, copy hierarchy suggestions, and CTA-focused layout design.',
                'valid_until' => Carbon::now()->addDays(6),
                'subtotal' => 1800,
                'discount' => 0,
                'total' => 1800,
                'notes' => 'Fast project. Great for quick case study delivery.',
            ],
            [
                'client_email' => 'khaled@eduvisionacademy.org',
                'title' => 'EduVision Academy Platform Refresh Proposal',
                'status' => 'draft',
                'intro_message' => 'This proposal outlines a refresh plan for EduVision Academy, covering course visibility, student onboarding flow, and improved educational platform structure.',
                'valid_until' => Carbon::now()->addDays(15),
                'subtotal' => 4100,
                'discount' => 100,
                'total' => 4000,
                'notes' => 'Possible phase 2: student dashboard and enrollment UX.',
            ],
        ];

        foreach ($proposals as $proposalData) {
            $client = $clients->get($proposalData['client_email']);

            if (! $client instanceof Client) {
                continue;
            }

            Proposal::updateOrCreate(
                [
                    'workspace_id' => $workspace->id,
                    'client_id' => $client->id,
                    'title' => $proposalData['title'],
                ],
                [
                    'workspace_id' => $workspace->id,
                    'client_id' => $client->id,
                    'status' => $proposalData['status'],
                    'intro_message' => $proposalData['intro_message'],
                    'valid_until' => $proposalData['valid_until'],
                    'subtotal' => $proposalData['subtotal'],
                    'discount' => $proposalData['discount'],
                    'total' => $proposalData['total'],
                    'notes' => $proposalData['notes'],
                ]
            );
        }

        $this->command->info('Demo proposals seeded successfully.');
    }
}
