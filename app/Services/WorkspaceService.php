<?php

namespace App\Services;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Str;

class WorkspaceService
{
    public function createDefaultForUser(User $user): Workspace
    {
        $workspaceName = $user->name . "'s Workspace";

        $baseSlug = Str::slug($user->name . '-workspace');
        $slug = $baseSlug;
        $counter = 1;

        while (Workspace::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return Workspace::create([
            'owner_id' => $user->id,
            'name' => $workspaceName,
            'slug' => $slug,
        ]);
    }
}
