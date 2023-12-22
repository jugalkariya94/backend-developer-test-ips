<?php

namespace App\Listeners;

use App\Events\LessonWatched;

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
        //
    }
}
