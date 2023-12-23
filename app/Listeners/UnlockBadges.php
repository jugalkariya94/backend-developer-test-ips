<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Models\Badge;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnlockBadges implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BadgeUnlocked $event): void
    {
        //
        $badge = Badge::where('name', $event->badgeName)->first();
        $event->user->badges()->syncWithoutDetaching([$badge->id => ['unlocked_at' => now()]]);
    }
}
