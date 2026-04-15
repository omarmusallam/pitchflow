<?php

namespace App\Services;

use App\Models\Proposal;

class ProposalActivityService
{
    public function log(
        Proposal $proposal,
        string $type,
        string $label,
        ?string $description = null,
        ?array $meta = null
    ): void {
        $proposal->activities()->create([
            'type' => $type,
            'label' => $label,
            'description' => $description,
            'meta' => $meta,
        ]);
    }
}
