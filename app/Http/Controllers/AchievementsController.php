<?php

namespace App\Http\Controllers;

use App\Enums\AchievementTypeEnum;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        // TODO: Refactor the code to move the data gathering to other services / models
        // get user data
        $totalCommentCount = $user->comments->count();
        $totalWatchedLessonsCount = $user->watched->count();
        $totalAchievements = $user->achievements->count();

        $unlockedAchivements = $user->achievements->pluck('name');
        $currentBadge = $user->current_badge;

        // get next available achievements / badge to unlock
        $nextLessonAchievement = Achievement::where('min_required_entries', '>', $totalWatchedLessonsCount)->where('class', AchievementTypeEnum::LESSON)->first();
        $nextCommentAchievement = Achievement::where('min_required_entries', '>', $totalCommentCount)->where('class', AchievementTypeEnum::COMMENT)->first();
        $nextBadge = Badge::where('id', '>', $currentBadge->id ?? 0)->first();

        return response()->json([
            'unlocked_achievements' => $unlockedAchivements,
            'next_available_achievements' => [
                $nextLessonAchievement->name,
                $nextCommentAchievement->name,
            ],
            'current_badge' => $user->current_badge->name ?? "",
            'next_badge' => $nextBadge->name ?? '',
            'remaing_to_unlock_next_badge' => ($nextBadge) ? ($nextBadge->min_required_achievements - $totalAchievements) : 0
        ]);
    }
}
