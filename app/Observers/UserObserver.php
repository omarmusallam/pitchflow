<?php

namespace App\Observers;

use App\Models\User;
use App\Services\WorkspaceService;

class UserObserver
{
    public function created(User $user): void
    {
        if ($user->workspace()->exists()) {
            return;
        }

        app(WorkspaceService::class)->createDefaultForUser($user);
    }
}
