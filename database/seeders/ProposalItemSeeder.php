<?php

namespace Database\Seeders;

use App\Models\Proposal;
use App\Models\ProposalItem;
use Illuminate\Database\Seeder;

class ProposalItemSeeder extends Seeder
{
    public function run(): void
    {
        $proposals = Proposal::all();

        if ($proposals->isEmpty()) {
            $this->command->warn('No proposals found. Pricing item seeding aborted.');
            return;
        }

        foreach ($proposals as $proposal) {
            $items = [
                [
                    'name' => 'Discovery & Planning',
                    'description' => 'Project scoping, research, planning, and structure definition.',
                    'quantity' => 1,
                    'unit_price' => 400,
                    'sort_order' => 1,
                ],
                [
                    'name' => 'UI/UX Design',
                    'description' => 'Interface design, responsive layout system, and visual direction.',
                    'quantity' => 1,
                    'unit_price' => 1200,
                    'sort_order' => 2,
                ],
                [
                    'name' => 'Frontend Implementation',
                    'description' => 'Clean responsive frontend implementation for the approved layouts.',
                    'quantity' => 1,
                    'unit_price' => 1500,
                    'sort_order' => 3,
                ],
                [
                    'name' => 'QA & Final Delivery',
                    'description' => 'Testing, revisions, polish, and final handoff preparation.',
                    'quantity' => 1,
                    'unit_price' => 300,
                    'sort_order' => 4,
                ],
            ];

            foreach ($items as $itemData) {
                $total = $itemData['quantity'] * $itemData['unit_price'];

                ProposalItem::updateOrCreate(
                    [
                        'proposal_id' => $proposal->id,
                        'name' => $itemData['name'],
                    ],
                    [
                        'proposal_id' => $proposal->id,
                        'description' => $itemData['description'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'total' => $total,
                        'sort_order' => $itemData['sort_order'],
                    ]
                );
            }

            $subtotal = (float) $proposal->items()->sum('total');
            $discount = (float) $proposal->discount;
            $total = max($subtotal - $discount, 0);

            $proposal->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);
        }

        $this->command->info('Proposal pricing items seeded successfully.');
    }
}
