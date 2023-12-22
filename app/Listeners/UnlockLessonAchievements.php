<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\Lesson;

class UnlockLessonAchievements
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
    public function handle(LessonWatched $event): void
    {
        // get user for watched lesson
        $user = $event->user;

        // get total watched lessons count for the user
        $totalWatchedLessonsCount = $user->watched->count();

        $achievement = Achievement::where('min_required_entries', $totalWatchedLessonsCount)->where('class', Lesson::class)->first();

        if (!empty($achievement)) {
            event(new AchievementUnlocked($achievement->name, $user));
        }
    }
}
