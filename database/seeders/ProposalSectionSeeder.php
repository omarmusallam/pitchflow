<?php

namespace Database\Seeders;

use App\Models\Proposal;
use App\Models\ProposalSection;
use Illuminate\Database\Seeder;

class ProposalSectionSeeder extends Seeder
{
    public function run(): void
    {
        $proposals = Proposal::with('client')->get();

        if ($proposals->isEmpty()) {
            $this->command->warn('No proposals found. Section seeding aborted.');
            return;
        }

        foreach ($proposals as $proposal) {
            $sections = [
                [
                    'type' => 'overview',
                    'title' => 'Project Overview',
                    'content' => "This proposal outlines the recommended approach for {$proposal->client?->name}'s project. The objective is to deliver a clear, modern, and effective solution aligned with business goals, user experience priorities, and long-term scalability.",
                    'sort_order' => 1,
                ],
                [
                    'type' => 'scope',
                    'title' => 'Scope of Work',
                    'content' => "The scope includes discovery, interface planning, responsive UI implementation, core page structure, and clean delivery of the agreed proposal requirements. Any items outside the approved scope may be quoted separately if needed.",
                    'sort_order' => 2,
                ],
                [
                    'type' => 'deliverables',
                    'title' => 'Deliverables',
                    'content' => "Final deliverables may include approved designs, implementation files, responsive layouts, structured proposal content, and a polished project handoff package depending on the selected engagement model.",
                    'sort_order' => 3,
                ],
                [
                    'type' => 'timeline',
                    'title' => 'Timeline',
                    'content' => "The estimated timeline for this project is between 2 to 4 weeks from kickoff, depending on feedback speed, project complexity, and content readiness. Progress updates will be shared regularly throughout execution.",
                    'sort_order' => 4,
                ],
                [
                    'type' => 'terms',
                    'title' => 'Terms & Notes',
                    'content' => "This proposal remains valid until the specified expiration date. Work begins after approval and initial payment confirmation, if applicable. Revisions are limited to the agreed scope unless otherwise stated.",
                    'sort_order' => 5,
                ],
            ];

            foreach ($sections as $section) {
                ProposalSection::updateOrCreate(
                    [
                        'proposal_id' => $proposal->id,
                        'title' => $section['title'],
                    ],
                    [
                        'proposal_id' => $proposal->id,
                        'type' => $section['type'],
                        'content' => $section['content'],
                        'sort_order' => $section['sort_order'],
                    ]
                );
            }
        }

        $this->command->info('Proposal sections seeded successfully.');
    }
}
