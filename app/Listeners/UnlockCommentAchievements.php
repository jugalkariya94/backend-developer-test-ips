<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Models\Achievement;
use App\Models\Comment;

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
        // get user from the comment
        $user = $event->comment->user;

        // get total comment count for the user
        $totalCommentCount = $user->comments->count();

        $achievement = Achievement::where('min_required_entries', $totalCommentCount)->where('class', Comment::class)->first();

        if (!empty($achievement)) {
            event(new AchievementUnlocked($achievement->name, $user));
        }
    }
}
