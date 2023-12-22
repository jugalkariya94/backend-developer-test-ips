<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Achievement;
use App\Models\Badge;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnlockAchievements implements ShouldQueue
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
    public function handle(AchievementUnlocked $event): void
    {
        //
        $user = $event->user;
        $achievement = Achievement::where('name', $event->achievementName)->first();
        $user->achievements()->syncWithoutDetaching([$achievement->id => ['unlocked_at' => now()] ]);

        $totalAchievements = $user->achievements->count();
        $badge = Badge::where('min_required_achievements', $totalAchievements)->first();

        if (!empty($badge)) {
            event(new BadgeUnlocked($badge->name, $user));
        }
    }
}
