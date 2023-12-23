<?php

namespace App\Listeners;

use App\Enums\BadgeNameEnum;
use App\Events\BadgeUnlocked;
use App\Models\Badge;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssignBadgeToNewUser implements ShouldQueue
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
    public function handle(Registered $event): void
    {
        //
        $badge = Badge::where('name', BadgeNameEnum::BEGINNER)->first();
        $event->user->badges()->syncWithoutDetaching([$badge->id => ['unlocked_at' => now()]]);
    }
}
