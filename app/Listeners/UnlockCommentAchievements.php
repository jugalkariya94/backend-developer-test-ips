<?php

namespace App\Listeners;

use App\Events\CommentWritten;

class UnlockCommentAchievements
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
    public function handle(CommentWritten $event): void
    {
        //
    }
}
